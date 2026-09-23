/*
 * BMS CORE NAVIGATION ENGINE — DO NOT ADD PROJECT-SPECIFIC JAVASCRIPT HERE.
 * Handles Bootstrap mega-menu sizing, desktop dropdown integration, mobile
 * offcanvas accordions, ARIA state and back-to-top behavior.
 * For project JS, create/enqueue a separate assets/js/project.js (or use a child theme).
 */
(function(){'use strict';
var desktop=function(){return window.innerWidth>=992;};
function fit(menu){var grid=menu.querySelector('.bms-mega-grid');if(!grid||!desktop())return;var items=[].filter.call(grid.children,function(el){return el.tagName==='LI';});if(!items.length)return;var w=grid.getBoundingClientRect().width;if(w<=0)return;var cols=Math.min(6,Math.max(1,Math.floor(w/210)),items.length);grid.style.setProperty('--bms-mega-columns',cols);}
function closeAll(){
 document.querySelectorAll('#primaryNavbar .bms-mega-parent > .dropdown-toggle.show').forEach(function(t){
   if(window.bootstrap){bootstrap.Dropdown.getOrCreateInstance(t).hide();}
 });
}
document.addEventListener('DOMContentLoaded',function(){
 /* Desktop mega menus intentionally use Bootstrap's native click behavior.
    No hover-open logic: click opens, clicking outside/Escape closes, matching normal dropdowns. */
 document.querySelectorAll('#primaryNavbar .bms-mega-parent > .dropdown-toggle').forEach(function(t){
   t.addEventListener('shown.bs.dropdown',function(){var p=t.parentElement,m=p&&p.querySelector(':scope > .bms-mega-menu');if(m)requestAnimationFrame(function(){fit(m);});});
 });
 var mobile=document.getElementById('bmsMobileNav');
 function mobileSubmenu(li){
   if(!li)return null;
   for(var i=0;i<li.children.length;i++){
     var child=li.children[i];
     if(child.classList&&(child.classList.contains('dropdown-menu')||child.classList.contains('submenu')||child.classList.contains('bms-mega-menu')))return child;
   }
   return null;
 }
 function setMobileSubmenu(li,force){
   var m=mobileSubmenu(li); if(!m)return;
   var btn=li.querySelector(':scope > .bms-mobile-accordion-toggle');
   var link=li.querySelector(':scope > a');
   var show=typeof force==='boolean'?force:!m.classList.contains('show');
   m.classList.toggle('show',show);
   li.classList.toggle('bms-mobile-open',show);
   if(btn){btn.classList.toggle('is-open',show);btn.setAttribute('aria-expanded',show?'true':'false');}
   if(link)link.setAttribute('aria-expanded',show?'true':'false');
 }
 if(mobile){mobile.addEventListener('click',function(e){
   if(desktop())return;
   var btn=e.target.closest('.bms-mobile-accordion-toggle');
   if(btn&&mobile.contains(btn)){
     e.preventDefault();e.stopPropagation();setMobileSubmenu(btn.closest('li'));return;
   }
   var link=e.target.closest('li > a');
   if(!link||!mobile.contains(link))return;
   var li=link.parentElement;
   if(mobileSubmenu(li)){
     /* On mobile the complete parent row is an accordion trigger. Child links remain normal links. */
     e.preventDefault();e.stopPropagation();setMobileSubmenu(li);return;
   }
 });}
 document.addEventListener('keydown',function(e){if(e.key==='Escape'){closeAll();var off=document.getElementById('bmsMobileNav');if(off&&off.classList.contains('show')&&window.bootstrap){bootstrap.Offcanvas.getOrCreateInstance(off).hide();}}});
 document.querySelectorAll('#bmsMobileNav a').forEach(function(a){a.addEventListener('click',function(){if(!desktop()&&mobileSubmenu(a.parentElement))return;var off=document.getElementById('bmsMobileNav');if(off&&window.bootstrap)bootstrap.Offcanvas.getOrCreateInstance(off).hide();});});
 var back=document.querySelector('.bms-back-to-top');if(back){var sync=function(){back.classList.toggle('is-visible',window.scrollY>500);};window.addEventListener('scroll',sync,{passive:true});sync();back.addEventListener('click',function(){window.scrollTo({top:0,behavior:window.matchMedia('(prefers-reduced-motion: reduce)').matches?'auto':'smooth'});});}
});
window.addEventListener('resize',function(){if(desktop())document.querySelectorAll('#primaryNavbar .bms-mega-menu.show').forEach(fit);});
}());
