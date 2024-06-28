var lastScrollTop = 0;

document.addEventListener('scroll', function() {
    var line = document.querySelector('.line');
    var firstSection = document.querySelector('.service-first-section-container');
    var lineBottom = line.getBoundingClientRect().bottom;
    var firstSectionTop = firstSection.getBoundingClientRect().top;
    var currentScrollTop = window.pageYOffset || document.documentElement.scrollTop;
    var speedFactor = 2.2;
    var maxDistance = firstSectionTop - lineBottom;  
    var distanceToMove = Math.min((currentScrollTop - lastScrollTop) * speedFactor, maxDistance);
    if (distanceToMove > 0 && currentScrollTop > lastScrollTop) {
        line.style.transform = 'translateY(' + distanceToMove + 'px)';
    } else if (currentScrollTop < lastScrollTop) {
        line.style.transform = 'translateY(0px)';
    }
    lastScrollTop = currentScrollTop <= 0 ? 0 : currentScrollTop;
});