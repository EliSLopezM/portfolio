/* dcc.js — Nav mobile toggle */
(function () {
    var toggle = document.getElementById('dccNavToggle');
    var links  = document.getElementById('dccNavLinks');
    if (!toggle || !links) return;
    toggle.addEventListener('click', function () {
        links.classList.toggle('open');
    });
})();

/* ══ Galería Spotlight DCC ══ */
(function () {
    var track    = document.getElementById('dccGalleryTrack');
    var dotsWrap = document.getElementById('dccGalleryDots');
    var prevBtn  = document.getElementById('dccGalleryPrev');
    var nextBtn  = document.getElementById('dccGalleryNext');
    if (!track) return;

    var items   = Array.from(track.querySelectorAll('.dcc-gallery-item'));
    var current = 0;
    var AUTO    = 4500;
    var timer   = null;

    function render() {
        items.forEach(function(item, i) {
            item.classList.remove('dcc-gallery-active','dcc-gallery-adjacent','dcc-gallery-hidden');
            item.style.display = '';
            var diff = i - current;
            if (diff === 0)            item.classList.add('dcc-gallery-active');
            else if (Math.abs(diff)===1) item.classList.add('dcc-gallery-adjacent');
            else                        { item.classList.add('dcc-gallery-hidden'); item.style.display='none'; }
        });
        if (dotsWrap) {
            Array.from(dotsWrap.children).forEach(function(d,i){
                d.classList.toggle('active', i===current);
            });
        }
    }

    function buildDots() {
        if (!dotsWrap) return;
        dotsWrap.innerHTML = '';
        items.forEach(function(_,i){
            var d = document.createElement('button');
            d.className = 'dcc-gallery-dot'+(i===0?' active':'');
            d.addEventListener('click', function(){ goTo(i); resetTimer(); });
            dotsWrap.appendChild(d);
        });
    }

    function goTo(idx) {
        current = ((idx % items.length) + items.length) % items.length;
        render();
    }

    function startTimer() { timer = setInterval(function(){ goTo(current+1); }, AUTO); }
    function resetTimer() { clearInterval(timer); startTimer(); }

    if (prevBtn) prevBtn.addEventListener('click', function(){ goTo(current-1); resetTimer(); });
    if (nextBtn) nextBtn.addEventListener('click', function(){ goTo(current+1); resetTimer(); });

    items.forEach(function(item,i){
        item.addEventListener('click', function(){
            if (i !== current) { goTo(i); resetTimer(); }
        });
    });

    track.addEventListener('mouseenter', function(){ clearInterval(timer); });
    track.addEventListener('mouseleave', startTimer);

    var sx = 0;
    track.addEventListener('touchstart', function(e){ sx=e.touches[0].clientX; clearInterval(timer); },{passive:true});
    track.addEventListener('touchend',   function(e){
        var dx = sx - e.changedTouches[0].clientX;
        if (Math.abs(dx)>40) goTo(dx>0?current+1:current-1);
        startTimer();
    });

    buildDots(); render(); startTimer();
})();