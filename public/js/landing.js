// Reveal on scroll and flash close handling
(function(){
    'use strict';

    function initReveals(){
        const reveals = document.querySelectorAll('.reveal');
        if(!reveals.length) return;

        // If IntersectionObserver available, use it
        if('IntersectionObserver' in window){
            const io = new IntersectionObserver((entries)=>{
                entries.forEach(entry=>{
                    if(entry.isIntersecting){
                        entry.target.classList.add('is-visible');
                        io.unobserve(entry.target);
                    }
                });
            },{ root:null, rootMargin:'0px', threshold:0.12 });
            reveals.forEach(el=>io.observe(el));
        } else {
            // Fallback: reveal all after a short delay
            setTimeout(()=>{ reveals.forEach(el=>el.classList.add('is-visible')); }, 120);
        }

        // Ensure elements already in viewport are revealed (handles SSR or fast loads)
        // small check for elements in viewport
        const rectReveal = (el)=>{
            const r = el.getBoundingClientRect();
            return (r.top < (window.innerHeight || document.documentElement.clientHeight) && r.bottom >= 0);
        };
        reveals.forEach(el=>{ if(rectReveal(el)) el.classList.add('is-visible'); });
    }

    // Init when DOM ready (script is loaded with defer but be safe)
    if(document.readyState === 'loading'){
        document.addEventListener('DOMContentLoaded', initReveals, {once:true});
    } else {
        initReveals();
    }

    // Fermeture des messages flash
    document.addEventListener('click', function(e){
        if(e.target.closest && e.target.closest('.flash-close')){
            const btn = e.target.closest('.flash-close');
            const msg = btn.closest('.flash-message');
            if(msg){
                // animation out
                msg.style.transition = 'opacity 280ms ease, transform 280ms ease';
                msg.style.opacity = '0';
                msg.style.transform = 'translateX(20px)';
                setTimeout(()=>{ if(msg && msg.parentNode) msg.parentNode.removeChild(msg); }, 320);
            }
        }
    }, {passive:true});

})();
