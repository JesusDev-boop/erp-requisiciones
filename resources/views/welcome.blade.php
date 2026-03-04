<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SISTEMA DE REQUISICIONES | CHEMISERVIS</title>
@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap');

:root{
    --brand:#0ea5e9;
    --brand2:#38bdf8;
    --dark:#020617;
}

body{
    margin:0;
    font-family:'Inter',sans-serif;
    background:var(--dark);
    color:white;
    overflow:hidden;
}

/* ===== AURORA ===== */
.bg-aurora{
    position:fixed;
    inset:0;
    z-index:0;
    pointer-events:none;
}
.bg-aurora::before,
.bg-aurora::after{
    content:'';
    position:absolute;
    width:1200px;
    height:1200px;
    border-radius:50%;
    filter:blur(140px);
    opacity:.25;
    animation:aurora 20s ease-in-out infinite alternate;
}
.bg-aurora::before{
    background:radial-gradient(circle,var(--brand),transparent 60%);
    top:-20%;
    left:-10%;
}
.bg-aurora::after{
    background:radial-gradient(circle,var(--brand2),transparent 60%);
    bottom:-20%;
    right:-10%;
}
@keyframes aurora{
    0%{transform:translate(0,0) scale(1);}
    100%{transform:translate(100px,-60px) scale(1.2);}
}

/* ===== PARTICLES ===== */
#particles{
    position:fixed;
    inset:0;
    z-index:1;
}

/* ===== GLASS ===== */
.glass-panel{
    background:linear-gradient(135deg,
        rgba(15,23,42,.75),
        rgba(15,23,42,.5));
    backdrop-filter:blur(40px);
    border:1px solid rgba(255,255,255,.08);
    box-shadow:0 40px 120px rgba(0,0,0,.7);
}

/* ===== LOGO EFFECT ===== */
.logo-wrapper{
    perspective:1000px;
}
.logo-tilt{
    transition:transform .2s ease;
    filter:drop-shadow(0 0 20px rgba(14,165,233,.4));
    animation:floatLogo 6s ease-in-out infinite alternate;
}
@keyframes floatLogo{
    from{transform:translateY(0px);}
    to{transform:translateY(12px);}
}

/* ===== BUTTON ===== */
.btn-executive{
    background:linear-gradient(135deg,var(--brand),var(--brand2));
    font-weight:800;
    letter-spacing:.15em;
    transition:.4s;
    box-shadow:0 15px 40px rgba(14,165,233,.4);
}
.btn-executive:hover{
    transform:translateY(-4px) scale(1.03);
    box-shadow:0 30px 80px rgba(14,165,233,.7);
}

/* ===== TYPE CURSOR ===== */
.type-cursor::after{
    content:"|";
    margin-left:4px;
    animation:blink 1s infinite;
}
@keyframes blink{
    50%{opacity:0;}
}
</style>
</head>

<body class="min-h-screen flex items-center justify-center p-6">

<div class="bg-aurora"></div>
<canvas id="particles"></canvas>

<div id="parallax" class="w-full max-w-6xl relative z-10">

<div class="glass-panel rounded-[2.5rem] overflow-hidden grid grid-cols-1 lg:grid-cols-12 min-h-[650px]">

<div class="lg:col-span-5 p-12 flex flex-col justify-center items-center text-center">

<div class="logo-wrapper mb-10">
<img id="logo" src="{{ asset('images/logo.png') }}" class="h-14 mx-auto logo-tilt">
</div>

<h1 id="titleMain" class="text-4xl font-extrabold type-cursor"></h1>

<p class="text-slate-400 text-sm mt-3 mb-10">
Sistema Inteligente CHEMISERVIS
</p>

<a href="{{ route('login') }}" class="w-full">
<button class="btn-executive w-full py-4 rounded-2xl uppercase text-sm">
Entrar al Sistema
</button>
</a>

</div>

<div class="hidden lg:flex lg:col-span-7 items-center justify-center p-16">
<h3 class="text-5xl font-extrabold">
<span id="titleHero" class="type-cursor"></span>
</h3>
</div>

</div>
</div>

<script>
/* ===== APPLE SMOOTH PARALLAX ===== */
const parallax=document.getElementById('parallax');
document.addEventListener('mousemove',e=>{
 const x=(e.clientX/window.innerWidth-0.5)*8;
 const y=(e.clientY/window.innerHeight-0.5)*8;
 parallax.style.transform=`rotateY(${x}deg) rotateX(${-y}deg)`;
});

/* ===== LOGO TILT ===== */
const logo=document.getElementById('logo');
document.addEventListener('mousemove',e=>{
 const x=(e.clientX/window.innerWidth-0.5)*20;
 const y=(e.clientY/window.innerHeight-0.5)*20;
 logo.style.transform=`rotateY(${x}deg) rotateX(${-y}deg)`;
});

/* ===== TYPEWRITER ===== */
function typeWriter(element,text,speed=70,callback=null){
 let i=0;
 function typing(){
  if(i<text.length){
   element.innerHTML+=text.charAt(i);
   i++;
   setTimeout(typing,speed);
  }else if(callback){callback();}
 }
 typing();
}

window.addEventListener("load",()=>{
 const main=document.getElementById("titleMain");
 const hero=document.getElementById("titleHero");
 typeWriter(main,"Portal ERP",60,()=>{
  hero.innerHTML="SISTEMA DE ";
  const span=document.createElement("span");
  span.classList.add("text-sky-400");
  hero.appendChild(span);
  typeWriter(span,"REQUISICIONES",60);
 });
});

/* ===== PARTICLES INTERACTIVE ===== */
const canvas=document.getElementById('particles');
const ctx=canvas.getContext('2d');
let particles=[];
let mouse={x:null,y:null};

canvas.width=window.innerWidth;
canvas.height=window.innerHeight;

window.addEventListener('resize',()=>{
 canvas.width=window.innerWidth;
 canvas.height=window.innerHeight;
});

window.addEventListener('mousemove',e=>{
 mouse.x=e.x;
 mouse.y=e.y;
});

for(let i=0;i<80;i++){
 particles.push({
  x:Math.random()*canvas.width,
  y:Math.random()*canvas.height,
  dx:(Math.random()-.5)*0.5,
  dy:(Math.random()-.5)*0.5,
  size:2
 });
}

function animate(){
 ctx.clearRect(0,0,canvas.width,canvas.height);

 for(let i=0;i<particles.length;i++){
  let p=particles[i];

  p.x+=p.dx;
  p.y+=p.dy;

  if(p.x<0||p.x>canvas.width) p.dx*=-1;
  if(p.y<0||p.y>canvas.height) p.dy*=-1;

  let dist=Math.hypot(mouse.x-p.x,mouse.y-p.y);
  if(dist<120){
   p.x+=(p.x-mouse.x)/20;
   p.y+=(p.y-mouse.y)/20;
  }

  ctx.beginPath();
  ctx.arc(p.x,p.y,p.size,0,Math.PI*2);
  ctx.fillStyle="rgba(56,189,248,0.7)";
  ctx.fill();

  for(let j=i;j<particles.length;j++){
   let p2=particles[j];
   let d=Math.hypot(p.x-p2.x,p.y-p2.y);
   if(d<100){
    ctx.strokeStyle="rgba(56,189,248,0.08)";
    ctx.lineWidth=1;
    ctx.beginPath();
    ctx.moveTo(p.x,p.y);
    ctx.lineTo(p2.x,p2.y);
    ctx.stroke();
   }
  }
 }

 requestAnimationFrame(animate);
}
animate();
</script>

</body>
</html>