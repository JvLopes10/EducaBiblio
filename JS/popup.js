// Obtém o elemento HTML com o ID 'popup' e atribui-o à constante 'popup'
const popup = document.getElementById('popup');

// Define uma função para lidar com a abertura e fechamento do popup
function handlePopup(open) {
    // Adiciona a classe 'opened' ao elemento se 'open' for verdadeiro, caso contrário, remove a classe
    popup.classList[open ? 'add' : 'remove']('opened');
}

// Obtém o elemento HTML com o ID 'popup1' e atribui-o à constante 'popup1'
const popup1 = document.getElementById('popup1');

// Define uma função para lidar com a abertura e fechamento do segundo popup
function handlePopup1(open) {
    // Adiciona a classe 'opened' ao elemento se 'open' for verdadeiro, caso contrário, remove a classe
    popup1.classList[open ? 'add' : 'remove']('opened');
}

// Obtém o elemento HTML com o ID 'popup2' e atribui-o à constante 'popup2'
const popup2 = document.getElementById('popup2');

// Define uma função para lidar com a abertura e fechamento do terceiro popup
function handlePopup2(open) {
    // Adiciona a classe 'opened' ao elemento se 'open' for verdadeiro, caso contrário, remove a classe
    popup2.classList[open ? 'add' : 'remove']('opened');
}
