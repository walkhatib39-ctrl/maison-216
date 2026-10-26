const assert=require('node:assert/strict'),Fastify=require('fastify')
const {prisma}=require('./dist-network-counts-20261026/db')
const {registerNetworkOpportunities}=require('./dist-network-counts-20261026/routes/networkOpportunities')
const {MAISON,LITORRA,SOURCES,revision,qualify,documents}=require('./dist-network-counts-20261026/lib/networkPolicy')
const id='00000000-0000-4000-8000-000000000001',mid='00000000-0000-4000-8000-000000000002',owner='owner'
const baseLead={id,userId:owner,wpSiteId:SOURCES[0],externalId:'tb-rfq-1',date:new Date(),nom:'Fixture',email:'fixture@example.test',telephone:'12345678',ville:'Tunis',service:'Peinture',followup:{contacted:false,notes:'INTERNAL'},metadata:{raw:{origin:'tunibusiness-v1',title:'Peinture de quatre étages',description:'Travaux de peinture intérieure de quatre étages.',documents:[{id:'a-1',name:'plan.pdf',mime:'application/pdf'}]}},wpSite:{name:'TuniBusiness',exportToken:'fixture'}}
const maisonLead={...baseLead,id:mid,externalId:'32',wpSiteId:MAISON,nom:'Autre client',email:'other@example.test',telephone:'87654321',message:'Repeindre un mur de 20 m²',metadata:{raw:{origin:'maison216-v1',documents:[{id:'m-0',name:'photo.heic',mime:'image/heic'}]}},wpSite:{name:'Maison216',exportToken:'fixture'}}
const leads=[baseLead,maisonLead],users={admin:{id:'admin',role:'admin'},maison:{id:'maison',role:'client',scopeSiteId:MAISON},litorra:{id:'litorra',role:'client',scopeSiteId:LITORRA}}
const decisions=new Map();let lastUrl=''
prisma.user.findUnique=async({where})=>users[where.id]
prisma.wpSite.findFirst=async({where})=>where.userId===owner?{id:where.id}:null
prisma.lead.findFirst=async({where})=>leads.find(l=>l.id===where.id&&l.userId===where.userId&&where.wpSiteId.in.includes(l.wpSiteId))||null
prisma.lead.findMany=async({where})=>typeof where.wpSiteId==='string'?leads.filter(l=>l.wpSiteId===where.wpSiteId):leads.filter(l=>where.wpSiteId.in.includes(l.wpSiteId))
prisma.$queryRaw=async(_s,destination)=>[...decisions.values()].filter(d=>d.destination_id===destination)
prisma.$executeRaw=async(strings,...v)=>{if(strings.join('?').startsWith('INSERT INTO network_opportunities(')){const [destination_id,source_lead_id,owner_id,status,source_revision,lot,reason,shared_brief,document_ids,approved_by,approved_at]=v;decisions.set(destination_id+source_lead_id,{destination_id,source_lead_id,owner_id,status,source_revision,lot,reason,shared_brief,document_ids,approved_by,approved_at})}return 1}
prisma.$transaction=async fn=>fn(prisma)
global.fetch=async(url)=>{lastUrl=String(url);return new Response(new Uint8Array([255,216,255]),{headers:{'Content-Type':'image/jpeg'}})}
;(async()=>{
const app=Fastify();app.addHook('preHandler',async r=>{r.user={sub:r.headers['x-user']||'admin',ownerId:owner}});registerNetworkOpportunities(app)
const endpoint=d=>'/site/'+d+'/network-opportunities',call=(u,method,url,payload)=>app.inject({method,url,headers:{'x-user':u},payload})
assert.equal((await call('maison','GET',endpoint(LITORRA))).statusCode,403)
assert.equal((await call('litorra','GET',endpoint(MAISON))).statusCode,403)
const pending=(await call('admin','GET',endpoint(LITORRA))).json();assert.equal(pending.groups.length,2);const summary=(await call('admin','GET',endpoint(LITORRA)+'?summary=1')).json();assert.equal(summary.counts.pending,2);assert.equal(summary.counts.actionable,2);assert(!('groups' in summary));assert(!JSON.stringify(summary).includes('Fixture'));assert(!JSON.stringify(summary).includes('fixture@example.test')); assert(pending.groups.every(g=>g.members[0].destinationName==='Litorra'))
assert.equal((await call('litorra','GET',endpoint(LITORRA))).json().groups.length,0)
const item=l=>({id:l.id,revision:revision(l),lot:'Peinture intérieure',reason:'Lot peinture explicite',brief:'Peinture du lot validé uniquement.',documents:documents(l).map(d=>d.id)})
assert.equal((await call('litorra','POST',endpoint(LITORRA)+'/review',{action:'approve',items:[item(baseLead)]})).statusCode,403)
assert.equal((await call('admin','POST',endpoint(LITORRA)+'/review',{action:'approve',items:[item(baseLead)]})).statusCode,200)
assert.equal((await call('litorra','GET',endpoint(LITORRA))).json().groups.length,1);let counts=(await call('admin','GET',endpoint(LITORRA)+'?summary=1')).json().counts;assert.equal(counts.pending,1);assert.equal(counts.toForward,1);decisions.get(LITORRA+id).forwarded_at=new Date();counts=(await call('admin','GET',endpoint(LITORRA)+'?summary=1')).json().counts;assert.equal(counts.actionable,1);assert.equal((await call('litorra','GET',endpoint(LITORRA)+'?summary=1')).json().counts.pending,0)
assert.equal((await call('maison','GET',endpoint(MAISON))).json().groups.length,0)
assert.equal((await call('maison','GET',endpoint(MAISON)+'/'+id+'/documents/a-1')).statusCode,404)
const pack=(await call('litorra','POST',endpoint(LITORRA)+'/export',{items:[{id,revision:revision(baseLead)}]})).json();assert.equal(pack.members[0].destinationName,'Litorra');assert(!JSON.stringify(pack).includes('INTERNAL'))
assert.equal((await call('admin','POST',endpoint(LITORRA)+'/review',{action:'approve',items:[item(maisonLead)]})).statusCode,200)
assert.equal((await call('litorra','GET',endpoint(LITORRA)+'/'+mid+'/documents/m-0?preview=1')).statusCode,200);assert(lastUrl.startsWith('https://maison216.tn/lead-export.php'));assert(lastUrl.includes('document=m-0')&&lastUrl.includes('preview=1'))
assert.equal((await call('admin','POST',endpoint(MAISON)+'/review',{action:'approve',items:[item(maisonLead)]})).statusCode,404)
assert.equal(decisions.size,2)
for(const text of ['Pas de peinture dans ce projet','Finition peinture blanche du meuble','Peinture automobile','Nous cherchons des relations de partenariat dans la peinture','TEST CRM peinture intérieure'])assert(!qualify({message:text,service:text.includes('meuble')?'Meuble':'',date:new Date()},LITORRA),text)
assert.equal(qualify({message:'Achat de 20 pots de peinture',date:new Date()},LITORRA).kind,'supply')
assert.equal(qualify({message:'Rénovation : plomberie, électricité et peinture des murs',date:new Date()},LITORRA).kind,'lot')
assert(qualify({message:'Application de béton ciré',date:new Date()},LITORRA))
assert(qualify({message:'Cuisines équipées sur mesure'},MAISON))
await app.close();console.log('PASS: isolation destinations, validation indépendante, sources autorisées, documents Maison216/HEIC, export Litorra, qualification peinture et régression Maison216.')
})().catch(e=>{console.error(e);process.exitCode=1})
