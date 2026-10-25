const fs=require('fs'),ts=require('typescript'),assert=require('assert/strict')
const e={};new Function('exports','require',ts.transpileModule(fs.readFileSync('src/lib/networkPdfCore.ts','utf8'),{compilerOptions:{module:ts.ModuleKind.CommonJS,target:ts.ScriptTarget.ES2022,esModuleInterop:true}}).outputText)(e,require)
const {PDFDocument}=require('pdf-lib'),{jsPDF}=require('jspdf')
;(async()=>{
const fonts={normal:fs.readFileSync('node_modules/dejavu-fonts-ttf/ttf/DejaVuSans.ttf').toString('base64'),bold:fs.readFileSync('node_modules/dejavu-fonts-ttf/ttf/DejaVuSans-Bold.ttf').toString('base64')}
const member={status:'approved',name:'Démonstration technique',phone:'+216 00 000 000',email:'test@example.test',city:'Tunis',lot:'Cuisine sur mesure',sourceSite:'Source de test',reference:'TEST-PDF',date:'2026-10-25',sharedBrief:'Cuisine équipée sur mesure : façade blanche, plan de travail bois et rangements fermés.\nDimensions : 3,60 m × 2,80 m.\nمطبخ حسب الطلب، خزائن وأبواب خشبية.\n'+Array.from({length:30},(_,i)=>`Précision ${i+1} : vérifier les dimensions, finitions et matériaux avec le client.`).join('\n')}
const original=new jsPDF();original.text('PLAN ORIGINAL - PAGE 1',20,30);original.rect(20,40,160,120);original.addPage();original.text('PLAN ORIGINAL - PAGE 2',20,30)
const jpg=new Uint8Array(fs.readFileSync('test-network-photo.jpg')),files=[{name:'Photo sélectionnée.jpg',mime:'image/jpeg',bytes:jpg,image:jpg,references:['TEST-PDF']},{name:'Plan original.pdf',mime:'application/pdf',bytes:new Uint8Array(original.output('arraybuffer')),references:['TEST-PDF']}]
const bytes=await e.buildNetworkPdf([member],files,fonts);fs.writeFileSync('/home/leadsc/backups/network-pdf-demo.pdf',bytes,{mode:0o600});const pdf=await PDFDocument.load(bytes);assert(pdf.getPageCount()>=5)
await assert.rejects(()=>e.buildNetworkPdf([{...member,status:'pending'}],files,fonts),/validation/)
const unsupported={name:'Plan.dwg',mime:'application/acad',bytes:new Uint8Array([1,2,3]),references:['TEST-PDF']}
await assert.rejects(()=>e.buildNetworkPdf([member],[unsupported],fonts),/ZIP/)
const zipPdf=await e.buildNetworkPdf([member],[...files,unsupported],fonts,true);assert((await PDFDocument.load(zipPdf)).getPageCount()>=5)
await assert.rejects(()=>e.buildNetworkPdf([member],[{...files[1],bytes:new Uint8Array([1,2,3])}],fonts),/fusionn/)
console.log(JSON.stringify({pages:pdf.getPageCount(),bytes:bytes.length,unicode:true,originalPdfPages:2,unsupportedAndCorruptHandled:true,pendingRejected:true}))
})().catch(e=>{console.error(e);process.exit(1)})
