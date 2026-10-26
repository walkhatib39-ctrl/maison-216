const assert=require('node:assert/strict'),Fastify=require('fastify'),fs=require('node:fs/promises')
const {prisma}=require('./dist-three-sites-20261026/db')
const {registerNetworkOpportunities}=require('./dist-three-sites-20261026/routes/networkOpportunities')
const {registerDirectLeadDocuments}=require('./dist-three-sites-20261026/routes/directLeadDocuments')
const {MEDINA,DELPHI,NADHEFNI,SOURCES,revision}=require('./dist-three-sites-20261026/lib/networkPolicy')
const ids=['00000000-0000-4000-8000-000000000001','00000000-0000-4000-8000-000000000002','00000000-0000-4000-8000-000000000003']
const leads=['Je souhaite faire construire une villa','Je recherche un photographe pour nos produits industriels','Prestation de nettoyage de bureaux'].map((message,i)=>({id:ids[i],userId:'owner',wpSiteId:SOURCES[0],externalId:'tb-rfq-'+i,date:new Date(),nom:'Fixture '+i,email:'f'+i+'@example.test',telephone:'1234567'+i,service:'Demande',message,metadata:{raw:{origin:'tunibusiness-v1',description:message,documents:[]}},wpSite:{name:'TuniBusiness'}}))
const direct={...leads[0],id:'00000000-0000-4000-8000-000000000004',wpSiteId:MEDINA,metadata:{files:[{nom:'test.pdf',type:'application/pdf',url:'/uploads/mail/test/file.pdf'}]},wpSite:{name:'Medina Construction'}}
const decisions=new Map(),users={admin:{id:'admin',role:'admin'},medina:{id:'medina',role:'client',scopeSiteId:MEDINA},delphi:{id:'delphi',role:'client',scopeSiteId:DELPHI},nadhefni:{id:'nadhefni',role:'client',scopeSiteId:NADHEFNI}}
prisma.user.findUnique=async({where})=>users[where.id]
prisma.wpSite.findFirst=async({where})=>where.userId==='owner'?{id:where.id}:null
prisma.lead.findMany=async({where})=>typeof where.wpSiteId==='string'?[]:leads.filter(l=>where.wpSiteId.in.includes(l.wpSiteId))
prisma.lead.findFirst=async({where})=>[...leads,direct].find(l=>l.id===where.id&&l.userId===where.userId&&(typeof where.wpSiteId==='string'?where.wpSiteId===l.wpSiteId:where.wpSiteId.in.includes(l.wpSiteId)))||null
prisma.$queryRaw=async(_s,destination)=>[...decisions.values()].filter(d=>d.destination_id===destination)
prisma.$executeRaw=async(strings,...v)=>{if(strings.join('?').startsWith('INSERT INTO network_opportunities(')){const [destination_id,source_lead_id,owner_id,status,source_revision,lot,reason,shared_brief,document_ids]=v;decisions.set(destination_id+source_lead_id,{destination_id,source_lead_id,owner_id,status,source_revision,lot,reason,shared_brief,document_ids})}return 1}
prisma.$transaction=async fn=>fn(prisma)
fs.realpath=async p=>p;fs.stat=async()=>({size:10});fs.readFile=async()=>Buffer.from('%PDF-fixture')
;(async()=>{
const app=Fastify();app.addHook('preHandler',async r=>{r.user={sub:r.headers['x-user']||'admin',ownerId:'owner'}});registerNetworkOpportunities(app);registerDirectLeadDocuments(app)
const call=(user,method,url,payload)=>app.inject({method,url,payload,headers:{'x-user':user}})
for(const [i,dest] of [MEDINA,DELPHI,NADHEFNI].entries()){
 const base='/site/'+dest+'/network-opportunities';const list=(await call('admin','GET',base)).json();assert.equal(list.groups.length,1);assert.equal(list.groups[0].members[0].id,ids[i]);assert.equal((await call('admin','GET',base+'?summary=1')).json().counts.pending,1)
 assert.equal((await call(['medina','delphi','nadhefni'][i],'GET',base)).json().groups.length,0)
 assert.equal((await call(['delphi','nadhefni','medina'][i],'GET',base)).statusCode,403)
 const lead=leads[i];assert.equal((await call('admin','POST',base+'/review',{action:'approve',items:[{id:lead.id,revision:revision(lead),lot:'Lot validé',reason:'Besoin explicite',brief:'Besoin validé pour ce site',documents:[]}]})).statusCode,200)
 assert.equal((await call(['medina','delphi','nadhefni'][i],'GET',base)).json().groups.length,1)
 const exported=(await call('admin','POST',base+'/export',{items:[{id:lead.id,revision:revision(lead)}]})).json();assert.equal(exported.members[0].destinationId,dest)
}
assert.equal(decisions.size,3)
const file=`/site/${MEDINA}/lead/${direct.id}/attachments/f-0`
assert.equal((await call('medina','GET',file)).statusCode,200)
assert.equal((await call('delphi','GET',file)).statusCode,403)
assert.equal((await call('admin','GET',file.replace('f-0','f-999'))).statusCode,404)
direct.metadata.files[0].url='/uploads/mail/../../secret';assert.equal((await call('admin','GET',file)).statusCode,400)
await app.close();console.log('PASS: trois destinations, compteurs, validation indépendante, export, droits et rattachement des documents directs.')
})().catch(e=>{console.error(e);process.exitCode=1})
