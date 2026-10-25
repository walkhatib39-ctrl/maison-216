const assert=require('node:assert/strict')
const Fastify=require('fastify')
const {prisma}=require('./dist-network-pdf-20261025/db')
const {registerNetworkOpportunities}=require('./dist-network-pdf-20261025/routes/networkOpportunities')
const {MAISON,SOURCES,revision,qualify,similar}=require('./dist-network-pdf-20261025/lib/networkPolicy')
const id='00000000-0000-4000-8000-000000000001',owner='owner'
const users={admin:{id:'admin',role:'admin'},team:{id:'team',role:'client',scopeSiteId:MAISON,scopeData:'leads'},other:{id:'other',role:'client',scopeSiteId:SOURCES[0]},second:{id:'second',role:'leads',scopeSiteId:MAISON},restricted:{id:'restricted',role:'client',scopeSiteId:MAISON,scopeData:'calls'}}
const lead={id,userId:owner,wpSiteId:SOURCES[0],externalId:'tb-rfq-1',date:new Date(),nom:'Test fixture',email:'fixture@example.test',telephone:'12345678',ville:'Tunis',service:'Demande',followup:{contacted:false,notes:'INTERNAL_SECRET'},metadata:{raw:{origin:'tunibusiness-v1',title:'Cuisine équipée sur mesure',description:'Cuisine équipée sur mesure, besoin de menuisier.',documents:[{id:'a-1',name:'plan.pdf',mime:'application/pdf'},{id:'q-2',name:'devis-concurrent.pdf',mime:'application/pdf'}],supplier_quotes:[{notes:'COMPETITOR_SECRET'}],ip:'IP_SECRET'}},wpSite:{name:'TuniBusiness',exportToken:'fixture'}}
const pristine=JSON.stringify(lead.followup);const decisions=new Map();let fetches=0
prisma.user.findUnique=async({where})=>users[where.id]||null
prisma.wpSite.findFirst=async({where})=>where.userId===owner?{id:MAISON}:null
prisma.lead.findFirst=async({where})=>where.id===id&&where.userId===owner?lead:null
prisma.lead.findMany=async({where})=>where.wpSiteId===MAISON?[]:[lead]
prisma.$queryRaw=async()=>[...decisions.values()]
prisma.$executeRaw=async(strings,...v)=>{const sql=strings.join('?');if(sql.startsWith('INSERT INTO network_opportunities(')){const [destination_id,source_lead_id,owner_id,status,source_revision,lot,reason,shared_brief,document_ids,approved_by,approved_at]=v;decisions.set(source_lead_id,{...decisions.get(source_lead_id),destination_id,source_lead_id,owner_id,status,source_revision,lot,reason,shared_brief,document_ids,approved_by,approved_at});return 1}if(sql.startsWith('UPDATE network_opportunities SET forwarded_at')){const d=decisions.get(id);if(d.forwarded_at)return 0;d.forwarded_at=new Date();d.forwarded_by=v[0];return 1}if(sql.startsWith('UPDATE network_opportunities')){const d=decisions.get(id);d.team_status=v[0];d.assigned_to=v[1];d.next_action=v[2];return 1}return 1}
prisma.$transaction=async fn=>fn(prisma)
global.fetch=async()=>{fetches++;return new Response(Buffer.from('%PDF-test'),{headers:{'Content-Type':'application/pdf'}})}
;(async()=>{
const app=Fastify();app.addHook('preHandler',async r=>{r.user={sub:r.headers['x-test-user']||'team',ownerId:owner}});registerNetworkOpportunities(app)
const base='/site/'+MAISON+'/network-opportunities'
const call=(user,method,url,payload)=>app.inject({method,url,headers:{'x-test-user':user},payload})
assert.equal((await call('other','GET',base)).statusCode,403)
assert.equal((await call('restricted','GET',base)).statusCode,403)
assert.equal((await call('team','GET',base)).json().groups.length,0)
assert.equal((await call('team','GET',base+'/'+id+'/documents/a-1')).statusCode,404)
assert.equal(fetches,0);assert.equal((await call('admin','POST',base+'/export',{items:[{id,revision:revision(lead)}]})).statusCode,409)
const review=()=>({action:'approve',items:[{id,revision:revision(lead),lot:'Cuisine sur mesure',reason:'Besoin explicite de cuisine',brief:'Besoin de cuisine sur mesure pour Maison216',documents:['a-1']}]})
assert.equal((await call('team','POST',base+'/review',review())).statusCode,403)
const pending=(await call('admin','GET',base)).json();assert.equal(pending.groups.length,1);assert.equal(pending.groups[0].members[0].documents.length,1)
const bad=review();bad.items[0].documents=['q-2'];assert.equal((await call('admin','POST',base+'/review',bad)).statusCode,400)
const stale=review();stale.items[0].revision='0'.repeat(64);assert.equal((await call('admin','POST',base+'/review',stale)).statusCode,409)
assert.equal((await call('admin','POST',base+'/review',review())).statusCode,200)
assert.equal((await call('admin','POST',base+'/review',review())).statusCode,200);assert.equal(decisions.size,1)
const exported=(await call('admin','POST',base+'/export',{items:[{id,revision:revision(lead)}]})).json();assert.equal(exported.members.length,1);assert.equal(exported.members[0].documents.length,1);assert.equal(exported.members[0].message,'Besoin de cuisine sur mesure pour Maison216');assert(!JSON.stringify(exported).includes('SECRET'));
const shared=await call('team','GET',base);assert.equal(shared.json().groups.length,1);assert(!shared.body.includes('SECRET'));assert(!shared.body.includes('exportToken'));assert.equal(shared.json().groups[0].members[0].message,'Besoin de cuisine sur mesure pour Maison216')
assert.equal((await call('team','GET',base+'/'+id+'/documents/a-1')).statusCode,200)
assert.equal((await call('team','GET',base+'/'+id+'/documents/q-2')).statusCode,404)
assert.equal((await call('team','PATCH',base+'/'+id+'/followup',{status:'taken',nextAction:'Appeler'})).statusCode,200)
assert.equal((await call('second','PATCH',base+'/'+id+'/followup',{status:'taken'})).statusCode,409)
assert.equal(JSON.stringify(lead.followup),pristine)
const delivery={items:[{id,revision:revision(lead)}]};assert.equal((await call('team','POST',base+'/delivery',delivery)).statusCode,403);assert.equal((await call('admin','POST',base+'/delivery',delivery)).json().count,1);assert.equal((await call('admin','POST',base+'/delivery',delivery)).json().count,0);
lead.metadata.raw.description+=' Nouvelle pièce et nouveau besoin.'
assert.equal((await call('team','GET',base)).json().groups.length,0)
assert.equal((await call('team','GET',base+'/'+id+'/documents/a-1')).statusCode,404)
assert.equal((await call('admin','POST',base+'/export',{items:[{id,revision:revision(lead)}]})).statusCode,409);
const revoked=review();revoked.action='revoke';assert.equal((await call('admin','POST',base+'/review',revoked)).statusCode,200)
assert.equal((await call('team','GET',base)).json().groups.length,0)
assert(!qualify({message:'Construction immeuble R+10'}));assert(!qualify({message:'Peinture immeuble'}));assert(!qualify({message:'TEST CRM cuisine équipée'}));assert(qualify({message:'Cuisines équipées sur mesure'}))
assert(!similar(lead,{...lead,email:'another@example.test'}))
await app.close();console.log('PASS: accès cible, validation admin, documents sélectionnés, exclusion devis fournisseur, révision, révocation, unicité, attribution, suivi source intact, qualification.')
})().catch(e=>{console.error(e);process.exitCode=1})
