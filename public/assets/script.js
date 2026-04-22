// Seleciona todas as imagens no grid
const images = document.querySelectorAll('.grid-container img');

// Cria elementos do modal
const modal = document.createElement('div');
modal.className = 'modal';

const modalImg = document.createElement('img');
modalImg.className = 'modal-content';

const closeBtn = document.createElement('span');
closeBtn.className = 'close';
closeBtn.innerHTML = '&times;';

// Cria botões de zoom
const zoomInBtn = document.createElement('button');
zoomInBtn.textContent = '+';

const zoomOutBtn = document.createElement('button');
zoomOutBtn.textContent = '-';

const resetBtn = document.createElement('button');
resetBtn.textContent = '↺';

const controls = document.createElement('div');
controls.className = 'zoom-controls';

// Adiciona botões ao container de controles
controls.appendChild(zoomInBtn);
controls.appendChild(zoomOutBtn);
controls.appendChild(resetBtn);

// Adiciona elementos ao modal
modal.appendChild(closeBtn);
modal.appendChild(modalImg);
modal.appendChild(controls);

// Adiciona o modal ao body
document.body.appendChild(modal);

// Variável para controlar o zoom
let scale = 1;

// Função para abrir o modal
function openModal(imgSrc) {
    modalImg.src = imgSrc;
    modal.style.display = 'block';
    scale = 1;
    modalImg.style.transform = `scale(${scale})`;
    document.body.style.overflow = 'hidden'; // Bloqueia scroll
}

// Função para fechar o modal
function closeModal() {
    modal.style.display = 'none';
    document.body.style.overflow = 'auto'; // Libera scroll
}

// Adiciona evento de clique a cada imagem
images.forEach(img => {
    img.addEventListener('click', () => {
        openModal(img.src);
    });
});

// Fecha o modal ao clicar no botão de fechar
closeBtn.addEventListener('click', closeModal);

// Fecha o modal ao clicar fora da imagem
modal.addEventListener('click', (e) => {
    if (e.target === modal) closeModal();
});

// Controles de zoom
zoomInBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    scale += 0.1;
    modalImg.style.transform = `scale(${scale})`;
});

zoomOutBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    if (scale > 0.2) scale -= 0.1;
    modalImg.style.transform = `scale(${scale})`;
});

resetBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    scale = 1;
    modalImg.style.transform = `scale(${scale})`;
});

// Controles por teclado
document.addEventListener('keydown', (e) => {
    if (modal.style.display === 'block') {
        switch(e.key) {
            case 'Escape':
                closeModal();
                break;
            case '+':
                scale += 0.1;
                modalImg.style.transform = `scale(${scale})`;
                break;
            case '-':
                if (scale > 0.2) scale -= 0.1;
                modalImg.style.transform = `scale(${scale})`;
                break;
            case '0':
                scale = 1;
                modalImg.style.transform = `scale(${scale})`;
                break;
        }
    }
});