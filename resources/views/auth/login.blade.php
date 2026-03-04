<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Acceso Corporativo | CHEMISERVIS</title>

@vite(['resources/css/app.css','resources/js/app.js'])

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

:root{
    --sky:#0ea5e9;
    --dark:#020617;
}

body{
    font-family:'Plus Jakarta Sans',sans-serif;
    background:var(--dark);
    color:#f8fafc;
    overflow-x:hidden;
}

/* GRID BACKGROUND */
.bg-pattern{
    position:fixed;
    inset:0;
    background-image:radial-gradient(rgba(56,189,248,.12) 1px,transparent 1px);
    background-size:24px 24px;
    z-index:0;
}

/* IA GLOW FOLLOW */
#aiGlow{
    position:fixed;
    width:420px;
    height:420px;
    border-radius:50%;
    pointer-events:none;
    z-index:2;
    background:radial-gradient(circle,
        rgba(56,189,248,0.25) 0%,
        rgba(56,189,248,0.12) 35%,
        rgba(56,189,248,0.05) 55%,
        transparent 70%);
    filter:blur(40px);
    transform:translate(-50%,-50%);
    opacity:.9;
}

/* GLASS */
.main-frame{
    background:rgba(15,23,42,.65);
    backdrop-filter:blur(25px);
    border:1px solid rgba(255,255,255,.08);
    box-shadow:0 50px 100px rgba(0,0,0,.7);
}

/* INPUT */
.input-field{
    background:rgba(2,6,23,.45);
    border:1px solid rgba(255,255,255,.1);
    color:white;
    transition:.25s;
}
.input-field:focus{
    border-color:var(--sky);
    box-shadow:0 0 20px rgba(14,165,233,.25);
    outline:none;
}

/* BUTTON */
.btn-execute{
    background:linear-gradient(135deg,#0ea5e9,#0284c7);
    transition:.3s;
    text-transform:uppercase;
    letter-spacing:.12em;
    font-weight:700;
}
.btn-execute:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 30px rgba(14,165,233,.4);
}

/* LOGO EFFECT */
.logo-pro{
    transition:.35s cubic-bezier(.4,0,.2,1);
    filter:drop-shadow(0 0 0 rgba(56,189,248,0));
}
.logo-pro:hover{
    transform:scale(1.08) rotate(-2deg);
    filter:drop-shadow(0 0 18px rgba(56,189,248,.6));
}

/* PARTICLES */
#particles{
    position:fixed;
    inset:0;
    z-index:1;
    pointer-events:none;
}

/* RIGHT GLOW */
.glow-right{
    position:absolute;
    width:600px;
    height:600px;
    background:radial-gradient(circle,rgba(14,165,233,.18),transparent 60%);
    filter:blur(120px);
    top:-120px;
    right:-120px;
}

/* FLOAT CARD */
.float-card{
    background:rgba(255,255,255,.03);
    border:1px solid rgba(255,255,255,.08);
    backdrop-filter:blur(20px);
    transition:.35s;
}
.float-card:hover{
    transform:translateY(-4px);
    border-color:rgba(56,189,248,.5);
}
</style>
</head>

<body class="min-h-screen flex items-center justify-center p-4">

<div class="bg-pattern"></div>
<canvas id="particles"></canvas>
<div id="aiGlow"></div>

<div class="relative z-10 w-full max-w-6xl">

<div class="main-frame rounded-[2.5rem] overflow-hidden grid grid-cols-1 lg:grid-cols-12 min-h-[650px]">

<!-- ================= LEFT LOGIN ================= -->
<div class="lg:col-span-5 p-12 lg:p-16 flex flex-col justify-center bg-white/[0.02]">

<div class="mb-12">
<img src="{{ asset('images/logo.png') }}" class="h-10 mb-10 logo-pro">

<h1 class="text-3xl font-extrabold tracking-tighter">
INICIO DE <span class="text-sky-400">SESION</span>
</h1>

<p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-2 italic">
Consola de Control
</p>
</div>

<form method="POST" action="{{ route('login') }}" class="space-y-6">
@csrf

<div>
<label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">
Identificador de Usuario
</label>
<input type="email" name="email" required
class="w-full input-field rounded-2xl px-5 py-4 text-sm"
placeholder="usuario@chemiservis.com">
</div>

<div>
<label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">
Clave de Acceso
</label>
<input type="password" name="password" required
class="w-full input-field rounded-2xl px-5 py-4 text-sm">
</div>

<button type="submit"
class="btn-execute w-full py-5 rounded-2xl text-xs text-white mt-6">
Validar Credenciales
</button>
</form>

<!-- MOTIVACIONAL -->
<div class="mt-10 bg-sky-500/10 border border-sky-400/30 rounded-2xl p-5">
<p class="text-sm text-sky-200">
🚀 Disciplina hoy, liderazgo mañana.<br>
<span class="text-slate-400 text-xs">
Cada acceso impulsa la eficiencia operativa de CHEMISERVIS.
</span>
</p>
</div>

</div>

<!-- ================= RIGHT PANEL ================= -->
<div class="hidden lg:flex lg:col-span-7 relative p-16 flex-col justify-between overflow-hidden">

<div class="glow-right"></div>

<div class="relative z-10 max-w-xl">

<h3 class="text-slate-400 text-xs font-black uppercase tracking-[0.4em] mb-8">
CHEMISERVIS SYSTEM
</h3>

<h2 class="text-5xl font-extrabold leading-tight mb-8">
Control total.<br>
<span class="text-sky-400">Decisiones inteligentes.</span>
</h2>

<p class="text-slate-400 text-base leading-relaxed mb-12">
Plataforma diseñada para maximizar la eficiencia operativa,
trazabilidad de Requisiciones y Ordenes de Compra.
</p>

<div class="float-card rounded-2xl p-6">
<p class="text-sm text-slate-300">
“La excelencia operativa no es un evento, es una cultura.”
</p>
</div>

</div>

<!-- METRICS -->
<div class="relative z-10 grid grid-cols-3 gap-6 mt-12">

<div class="float-card rounded-2xl p-5">
<div class="text-sky-400 text-2xl font-extrabold">100%</div>
<div class="text-slate-500 text-xs uppercase tracking-widest mt-1">
Controlado
</div>
</div>

<div class="float-card rounded-2xl p-5">
<div class="text-sky-400 text-2xl font-extrabold">+120</div>
<div class="text-slate-500 text-xs uppercase tracking-widest mt-1">
Proveedores
</div>
</div>

<div class="float-card rounded-2xl p-5">
<div class="text-sky-400 text-2xl font-extrabold">24/7</div>
<div class="text-slate-500 text-xs uppercase tracking-widest mt-1">
Operación
</div>
</div>

</div>

</div>
</div>

<div class="mt-8 text-center text-[10px] text-slate-700 uppercase tracking-[0.4em]">
· Chemiservis Network · TI
</div>

</div>

<script>
/* PARTICLES REACTIVAS */
const canvas=document.getElementById('particles');
const ctx=canvas.getContext('2d');

let particles=[];
let mouse={x:null,y:null};

function resize(){
canvas.width=window.innerWidth;
canvas.height=window.innerHeight;
}
window.addEventListener('resize',resize);
resize();

document.addEventListener('mousemove',e=>{
mouse.x=e.clientX;
mouse.y=e.clientY;
});

for(let i=0;i<70;i++){
particles.push({
x:Math.random()*canvas.width,
y:Math.random()*canvas.height,
r:Math.random()*2+0.5,
dx:(Math.random()-.5)*0.4,
dy:(Math.random()-.5)*0.4
});
}

function animate(){
ctx.clearRect(0,0,canvas.width,canvas.height);

particles.forEach(p=>{
let dx=mouse.x-p.x;
let dy=mouse.y-p.y;
let dist=Math.sqrt(dx*dx+dy*dy);

if(dist<120){
p.x-=dx*0.01;
p.y-=dy*0.01;
}

p.x+=p.dx;
p.y+=p.dy;

ctx.beginPath();
ctx.arc(p.x,p.y,p.r,0,Math.PI*2);
ctx.fillStyle='rgba(56,189,248,.7)';
ctx.fill();
});

requestAnimationFrame(animate);
}
animate();

/* IA GLOW FOLLOW */
const glow=document.getElementById('aiGlow');
let gx=window.innerWidth/2;
let gy=window.innerHeight/2;
let tx=gx, ty=gy;

document.addEventListener('mousemove',e=>{
tx=e.clientX;
ty=e.clientY;
});

function animateGlow(){
gx+=(tx-gx)*0.08;
gy+=(ty-gy)*0.08;
glow.style.left=gx+'px';
glow.style.top=gy+'px';
requestAnimationFrame(animateGlow);
}
animateGlow();
</script>

</body>
</html>