document.addEventListener('DOMContentLoaded', () => {
    // Countdown timer
    function updateTimer() {
        const hours = document.getElementById('hours');
        const minutes = document.getElementById('minutes');
        const seconds = document.getElementById('seconds');

        if (!hours || !minutes || !seconds) return; // Ngăn lỗi nếu chưa có DOM

        let h = parseInt(hours.textContent);
        let m = parseInt(minutes.textContent);
        let s = parseInt(seconds.textContent);

        s--;

        if (s < 0) {
            s = 59;
            m--;
            if (m < 0) {
                m = 59;
                h--;
                if (h < 0) {
                    h = 0;
                    m = 0;
                    s = 0;
                }
            }
        }

        hours.textContent = h.toString().padStart(2, '0');
        minutes.textContent = m.toString().padStart(2, '0');
        seconds.textContent = s.toString().padStart(2, '0');
    }

    setInterval(updateTimer, 1000);

    // Navigation buttons (for desktop)
    const prevBtn = document.getElementById('flash-prev');
    const nextBtn = document.getElementById('flash-next');
    const grid = document.querySelector('.flash-deal-grid');

    if (prevBtn && nextBtn && grid) {
        prevBtn.addEventListener('click', () => {
            grid.scrollBy({ left: -200, behavior: 'smooth' });
        });

        nextBtn.addEventListener('click', () => {
            grid.scrollBy({ left: 200, behavior: 'smooth' });
        });
    }
});
