import { Wheel } from '../../assets/vendor/spinWheel/dist/spin-wheel-esm.js';
import { loadFonts, loadImages } from '../../assets/vendor/spinWheel/scripts/util.js';

window.onload = async () => {
    const container = document.querySelector('.wheel-wrapper');
    const btnSpin = document.querySelector('.btn-spin');
    // if (!container || !btnSpin) { console.error('Elemen tidak ditemukan!'); return; }

    // Load overlay (pointer gambar)
    const overlayImg = new Image();
    overlayImg.src = './assets/vendor/spinWheel/img/bg-spin.svg';
    await loadImages([overlayImg]);

    // Load font
    await loadFonts([{ name: 'Oswald', url: 'https://fonts.googleapis.com/css2?family=Oswald&display=swap' }]);

    // Ambil items dari backend
    const rewardItems = await fetchItemsFromBackend();
    if (!Array.isArray(rewardItems) || rewardItems.length === 0) { console.error('Items kosong.'); return; }

    // Buat image objects untuk preloading
    const itemImages = rewardItems.map(it => {
        const img = new Image();
        img.src = it.image;
        return img;
    });
    await loadImages(itemImages);

    // Warna segmen
    const rewardColors = [
          '#262930'
        ];


    // Buat props untuk wheel
    const props = {
        overlayImage: overlayImg,
        itemBackgroundColors: rewardColors,
        items: rewardItems.map((it, idx) => ({
            label: it.label,
            image: itemImages[idx],
            imageRadius: 0.6,
        })),
        itemLabelAlign: 'center',
        itemLabelRotation: 0,
        radius: 0.88,
        itemLabelRadius: 0.45,
        itemLabelBaselineOffset: 0,
        itemLabelFont: 'Oswald',
        itemLabelFontSizeMax: 0,
        itemImageRadius: 0,
        itemImageSizeMax: 90,
        rotationSpeedMax: 700,
        rotationResistance: -70,
        lineWidth: 1,
        lineColor: '#fff',
        isInteractive:false,
        onRest: e => {
            const index = e.currentIndex;
            const reward = rewardItems[index];

            const label = reward?.label || '(Hadiah tidak ditemukan)';
            const image = reward?.image || '';

            const rewardContainer = document.getElementById('reward-container');
            rewardContainer.innerHTML = `
                <div class="reward-item text-center">
                    <div style="font-size: 2rem; color: #28a745;" class="mb-2">🎉 Selamat! 🎉</div>
                    <h4 class="reward-label fw-bold mb-1">Anda mendapatkan:</h4>
                    <h3 class="reward-label text-danger mb-2">${label}</h3>
                    ${image ? `<img src="${image}" alt="${label}" style="max-width: 150px;" class="img-fluid mt-2">` : ''}
                </div>
            `;

            $('#modalHadiah').modal('show');
        }
    };

    const wheel = new Wheel(container, props);
    container.style.visibility = 'visible';

    $(btnSpin).on('click', async () => {
        const reward = await fetchWinningItemIndexFromApi(rewardItems.length);
        if(reward.status){
            const index = reward.index;
            wheel.spinToItem(index, 1600, true, 20, 1, null);
            if(reward.saldo_reward < reward.harga_spin){
                $('#btnContainer').html(`<button class="btn btn-secondary rounded-pill px-5" disabled>Saldo Reward tidak Cukup</button>`);
            }
        } else {
            alert(reward.error);
        }
    });


    function fetchItemsFromBackend() {
        return new Promise(resolve => {
            $.ajax({
                url: 'controller/spin_reward/items.php',
                method: 'POST',
                dataType: 'json',
                success(resp) { resolve(resp.items || []); },
                error() { resolve([]); }
            });
        });
    }

    function fetchWinningItemIndexFromApi(count) {
        return new Promise(resolve => {
            $.ajax({
                url: 'controller/spin_reward/klaim_reward.php',
                method: 'POST',
                dataType: 'json',
                success(resp) { resolve(resp); },
                error() { resolve(); }
            });
        });
    }
};
