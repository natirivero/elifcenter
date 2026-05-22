(function(){
    if (typeof document === 'undefined') return;
    function init() {
        var bar = document.querySelector('.brand-bar');
        var burger = document.querySelector('.brand-burger');
        var nav = document.getElementById('brand-nav');
        if (!bar || !burger || !nav) return;

        function setOpen(open) {
            bar.classList.toggle('is-nav-open', open);
            burger.setAttribute('aria-expanded', open ? 'true' : 'false');
            burger.setAttribute('aria-label', open ? 'Cerrar menú' : 'Abrir menú');
        }

        burger.addEventListener('click', function(e){
            e.preventDefault();
            setOpen(!bar.classList.contains('is-nav-open'));
        });

        nav.addEventListener('click', function(e){
            if (e.target && e.target.closest('a')) setOpen(false);
        });

        document.addEventListener('keydown', function(e){
            if (e.key === 'Escape' && bar.classList.contains('is-nav-open')) {
                setOpen(false);
                burger.focus();
            }
        });

        var mq = window.matchMedia('(min-width: 769px)');
        var onChange = function(ev){ if (ev.matches) setOpen(false); };
        if (mq.addEventListener) mq.addEventListener('change', onChange);
        else if (mq.addListener) mq.addListener(onChange);
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
