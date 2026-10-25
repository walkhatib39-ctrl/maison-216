const assert=require('node:assert/strict'),Fastify=require('fastify'),fs=require('node:fs')
const {prisma}=require('./dist-inspirations-20261026/db')
const {registerLeadInspirations,stampImage}=require('./dist-inspirations-20261026/routes/leadInspirations')
const {sourceHash,hash,cleanBrief,inspirationEligibility}=require('./dist-inspirations-20261026/lib/inspirationPolicy')
const site='b4a9bcd7-8813-4206-aa2c-525e3d525b9c',id='00000000-0000-4000-8000-000000000001',imageId='00000000-0000-4000-8000-000000000002'
const lead={id,userId:'owner',wpSiteId:site,nom:'Client Exemple',email:'client@example.test',telephone:'22 123 456',service:'Cuisine',message:'Cuisine équipée sur mesure, bois brun foncé, façades simples. Téléphone 22 123 456. client@example.test',metadata:{raw:{documents:[]}}}
const brief=cleanBrief(lead),row={id:imageId,lead_id:id,destination_id:site,source_hash:sourceHash(lead,site),prompt_hash:hash(brief+'\n'),brief,status:'ready',client_state:'proposed',created_at:new Date()}
prisma.user.findUnique=async({where})=>({id:where.id,role:where.id==='admin'?'admin':'client'})
prisma.wpSite.findFirst=async({where})=>where.userId==='owner'?{id:site}:null
prisma.lead.findFirst=async({where})=>where.id===id&&where.userId==='owner'?lead:null
prisma.openAiApiKey.findUnique=async()=>({userId:'owner',apiKey:'NEVER_USED'})
prisma.$queryRaw=async()=>[row]
prisma.$executeRaw=async(strings,...v)=>{if(strings.join('?').includes('SET client_state')){row.client_state=v[0];row.client_note=v[1]}return 1}
;(async()=>{
const app=Fastify();app.addHook('preHandler',async r=>{r.user={sub:r.headers['x-user']||'admin',ownerId:r.headers['x-owner']||'owner'}});registerLeadInspirations(app)
const base=`/site/${site}/lead/${id}/inspirations`,call=(method,url,payload,headers={})=>app.inject({method,url,payload,headers})
assert(!brief.includes('client@example.test'));assert(!brief.includes('22 123 456'))
assert(inspirationEligibility(lead).eligible);assert(!inspirationEligibility({...lead,nom:'TEST NE PAS TRAITER'}).eligible)
assert(!inspirationEligibility({...lead,metadata:{photos:['photo.jpg']}}).eligible)
assert(!inspirationEligibility({...lead,message:'Cafet'}).eligible)
assert.equal((await call('GET',base,null,{'x-user':'client'})).statusCode,403)
assert.equal((await call('GET',base,null,{'x-owner':'another'})).statusCode,404)
const get=(await call('GET',base)).json();assert.equal(get.history[0].clientState,'proposed')
const cached=(await call('POST',base,{sourceHash:row.source_hash,brief})).json();assert(cached.cached);assert.equal(cached.item.id,imageId)
assert.equal((await call('POST',base,{sourceHash:'0'.repeat(64),brief})).statusCode,409)
assert.equal((await call('PATCH',base+'/'+imageId,{state:'client_approved',note:''})).statusCode,400)
assert.equal((await call('PATCH',base+'/'+imageId,{state:'client_approved',note:'Confirmation reçue par WhatsApp : style accepté.'})).statusCode,200)
lead.message+=' Modification du besoin.'
assert.equal((await call('PATCH',base+'/'+imageId,{state:'sent',note:''})).statusCode,409)
const photo=fs.readFileSync('../client/test-network-photo.jpg');const stamped=await stampImage(photo);assert(stamped.length>1000);fs.writeFileSync('/home/leadsc/backups/inspiration-stamp-test.png',stamped,{mode:0o600})
await app.close();console.log('PASS: droits, confidentialité du prompt, photo existante, fiche courte/test, cache sans API, besoin périmé, accord client explicite et marquage image.')
})().catch(e=>{console.error(e);process.exitCode=1})
