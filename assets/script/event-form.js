const body = document.querySelector('body')

// -------------- START - handling the display SVG icon
const inputsWhatsIncluded = document.querySelectorAll('#event_gatheringComplementsIncluded input')
const labelsWhatsIncluded = document.querySelectorAll('#event_gatheringComplementsIncluded label')
const blockWhatsIncluded = document.querySelector('#event_gatheringComplementsIncluded')


for (let index = 0; index < inputsWhatsIncluded.length; index++) {

    // 1) Transformer les span en icon
    const currentInput = inputsWhatsIncluded[index];
    currentInput.style.display = "none";

    const currentLabel = labelsWhatsIncluded[index];
    currentLabel.classList.add('material-icons');

    // le nom de l'icon SVG a mettre en texte pour la faire apparaitre
    const inputValue = currentInput.value;

    const paraph = document.createElement('p')
    paraph.innerText = inputValue
    paraph.style.textAlign = 'center'

    const div = document.createElement('div')
    div.classList.add('block-label-whats-included')
    div.appendChild(paraph)
    div.appendChild(currentLabel)

    blockWhatsIncluded.appendChild(div)

    // 2) Donner du style au input s'il sont checked true or false
    currentInput.addEventListener('change', function() {
        if (currentInput.checked == false) {
            currentLabel.classList.remove('checked')
        } else if (currentInput.checked == true) {
            currentLabel.classList.remove('not-checked')
            currentLabel.classList.add('checked')
        }
    })
}

const inputsWhatToBring = document.querySelectorAll('#event_gatheringComplementsToBring input')
const labelsWhatToBring = document.querySelectorAll('#event_gatheringComplementsToBring label')
const blockWhatToBring = document.querySelector('#event_gatheringComplementsToBring')


for (let index = 0; index < inputsWhatToBring.length; index++) { 


    // 1) Transformer les span en icon
    const currentInput = inputsWhatToBring[index];
    currentInput.style.display = "none";

    const currentLabel = labelsWhatToBring[index];
    currentLabel.classList.add('material-icons');

    // le nom de l'icon SVG a mettre en texte pour la faire apparaitre
    const inputValue = currentInput.value;

    const paraph = document.createElement('p')
    paraph.innerText = inputValue
    paraph.style.textAlign = 'center'

    const div = document.createElement('div')
    div.classList.add('block-label-what-to-bring')
    div.appendChild(paraph)
    div.appendChild(currentLabel)

    blockWhatToBring.appendChild(div)


    // 2) Donner du style au input s'il sont checked true or false
    currentInput.addEventListener('change', function() {
        if (currentInput.checked == false) {
            currentLabel.classList.remove('checked')
        } else if (currentInput.checked == true) {
            currentLabel.classList.remove('not-checked')
            currentLabel.classList.add('checked')
        }
    })
}

// -------------- END - handling the display SVG icon


// --------------- START - showing images pre upload from the form

let blockPictures = document.createElement('div')
blockPictures.classList.add('group-event-pictures')

let rowPictures = document.querySelector('.event-form-row-pictures')
let inputEventPictures = document.getElementById('event_eventPictures')

inputEventPictures.addEventListener('change', function() {

    blockPictures.innerHTML = "";
    const files = inputEventPictures.files;

    // check : limit to 5 files
    // if upload more, only the 5 first will be set
    if (inputEventPictures.files.length > 5) {
        const dataTransfer = new DataTransfer();

        for (let index = 0; index < 5; index++) {
            const file = files[index]
            dataTransfer.items.add(file)
        }

        inputEventPictures.files = dataTransfer.files
    }

    for (let i = 0; i < inputEventPictures.files.length; i++) {
        const file = inputEventPictures.files[i];
        let image = document.createElement('img')
        image.src = URL.createObjectURL(file)
        image.alt = file.name

        blockPictures.appendChild(image)
    }

    rowPictures.appendChild(blockPictures);

})

// ------

// let blockCover = document.createElement('div')
// blockCover.classList.add('group-event-cover')

let blockCover = document.querySelector('.group-event-cover')  
let rowCover = document.querySelector('.event-form-row-cover')  

let inputEventCover = document.getElementById('event_eventCover')
inputEventCover.addEventListener('change', function() {

    blockCover.innerHTML = ""

    const files = inputEventCover.files

    let image = document.createElement('img')
    image.src = URL.createObjectURL(files[0])

    blockCover.appendChild(image)
    rowCover.appendChild(blockCover)

})

// --------------- END - showing images pre upload from the form
