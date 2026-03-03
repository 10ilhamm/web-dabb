document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href !== '#') {
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
    });
});

let youtubeIndex = 0;

function showYoutubeVideo(n) {
    const videos = document.querySelectorAll('.youtube-video');
    const dots = document.querySelectorAll('.youtube-dot');

    if (n >= videos.length) { youtubeIndex = 0; }
    if (n < 0) { youtubeIndex = videos.length - 1; }

    videos.forEach(v => {
        v.style.display = 'none';
    });
    dots.forEach(d => {
        d.classList.remove('active');
    });

    if (videos[youtubeIndex]) videos[youtubeIndex].style.display = 'flex';
    if (dots[youtubeIndex]) dots[youtubeIndex].classList.add('active');
}

const prevButton = document.getElementById('youtube-prev');
const nextButton = document.getElementById('youtube-next');

if (prevButton) {
    prevButton.addEventListener('click', () => {
        youtubeIndex--;
        showYoutubeVideo(youtubeIndex);
    });
}

if (nextButton) {
    nextButton.addEventListener('click', () => {
        youtubeIndex++;
        showYoutubeVideo(youtubeIndex);
    });
}

document.querySelectorAll('.youtube-dot').forEach((dot, index) => {
    dot.addEventListener('click', () => {
        youtubeIndex = index;
        showYoutubeVideo(youtubeIndex);
    });
});

showYoutubeVideo(0);
