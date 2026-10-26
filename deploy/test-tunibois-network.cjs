const assert=require('node:assert/strict'),Fastify=require('fastify')
const {prisma}=require('./dist-tunibois-network-20261027/db')
const {registerNetworkOpportunities}=require('./dist-tunibois-network-20261027/routes/networkOpportunities')
const {TUNIBOIS,MAISON,SOURCES,revision,qualify}=require('./dist-tunibois-network-20261027/lib/networkPolicy')
const id='00000000-0000-4000-8000-000000000001',lead={id,userId:'owner',wpSiteId:SOURCES[0],externalId:'tb-rfq-1',date:new Date(),nom:'Fixture',email:'fixture@example.test',telephone:'12345678',ville:'Tunis',service:'Fourniture',message:'Achat de 500 palettes en bois pour notre entreprise',metadata:{raw:{origin:'tunibusiness-v1',description:'Achat de 500 palettes en bois pour notre entreprise',documents:[]}},wpSite:{name:'TuniBusiness'}}
const users={admin:{id:'admin',role:'admin'},team:{id:'team',role:'client',scopeSiteId:TUNIBOIS},other:{id:'other',role:'client',scopeSiteId:MAISON}},decisions=[]
prisma.user.findUnique=async({where})=>users[where.id]
prisma.wpSite.findFirst=async({where})=>where.userId==='owner'?{id:where.id}:null
prisma.lead.findMany=async({where})=>typeof where.wpSiteId==='string'?[]:[lead]
prisma.lead.findFirst=async({where})=>where.id===id&&where.wpSiteId.in.includes(lead.wpSiteId)?lead:null
prisma.$queryRaw=async(_s,d)=>decisions.filter(x=>x.destination_id===d)
prisma.$executeRaw=async(strings,...v)=>{if(strings.join('?').startsWith('INSERT INTO network_opportunities(')){const [destination_id,source_lead_id,owner_id,status,source_revision,lot,reason,shared_brief,document_ids]=v;const i=decisions.findIndex(x=>x.destination_id===destination_id&&x.source_lead_id===source_lead_id);const row={destination_id,source_lead_id,owner_id,status,source_revision,lot,reason,shared_brief,document_ids};if(i<0)decisions.push(row);else decisions[i]=row}return 1}
prisma.$transaction=async fn=>fn(prisma)
;(async()=>{const app=Fastify();app.addHook('preHandler',async r=>{r.user={sub:r.headers['x-user']||'admin',ownerId:'owner'}});registerNetworkOpportunities(app);const base='/site/'+TUNIBOIS+'/network-opportunities',call=(user,method,url,payload)=>app.inject({method,url,payload,headers:{'x-user':user}})
assert.equal((await call('other','GET',base)).statusCode,403)
assert.equal((await call('team','GET',base)).json().groups.length,0)
assert.equal((await call('admin','GET',base+'?summary=1')).json().counts.pending,1)
const payload={action:'approve',items:[{id,revision:revision(lead),lot:'Palettes en bois',reason:'Commande de palettes',brief:'500 palettes demandées',documents:[]}]}
assert.equal((await call('team','POST',base+'/review',payload)).statusCode,403)
assert.equal((await call('admin','POST',base+'/review',payload)).statusCode,200)
assert.equal((await call('admin','POST',base+'/review',payload)).statusCode,200);assert.equal(decisions.length,1)
const exported=(await call('team','POST',base+'/export',{items:[{id,revision:revision(lead)}]})).json();assert.equal(exported.members[0].destinationName,'Tunibois')
for(const text of ['Rayonnage pour stockage de sacs sur palettes','Conditionnement des bouteilles par pack et palette','Palette de couleurs','Un meuble TV blanc mat et bois naturel','Mon terrain contient des oliviers','TEST TECHNIQUE copeaux de bois'])assert.equal(qualify({message:text},TUNIBOIS),null,text)
for(const text of ['Achat de 500 palettes en bois','Besoin de copeaux de bois','Panneaux massifs collés','100000 bâtonnets pour glaces','Sous-tasses en bois d’olivier pour notre marque'])assert(qualify({message:text},TUNIBOIS),text)
assert.equal(qualify({message:'Meuble tv avec habillage en bois led'},TUNIBOIS).kind,'lot')
await app.close();console.log('PASS: Tunibois qualification, faux positifs exclus, accès ciblé, validation, unicité et export sous la bonne marque.')})().catch(e=>{console.error(e);process.exit(1)})
