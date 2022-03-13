import create from "/Module/Create.js";

let dialog = {};

dialog.create = ({
    title,
    message,
    buttons,
    section,
    className
}) => {
    if(is.empty(className)){
        className = 'dialog';
    }
    const div = create('div', className);
    const head = create('div', 'head');
    const body = create('div', 'body');
    const footer = create('div', 'footer');
    head.html('<h1>' + title + '</h1><span class="close"><i class="fas fa-window-close"></i></span>');
    body.html('<p>' + message  + '</p>');
    if(buttons.length === 1){
        footer.html('<div class="w-100 d-inline-block text-center"><button type="button" class="btn btn-primary button-submit">' + buttons[0].text +'</button></div>');
    }
    else if (buttons.length === 2){
        footer.html('<div class="w-50 d-inline-block text-center"><button type="button" class="btn btn-primary button-submit">' + buttons[0].text +'</button></div><div class="w-100 d-inline-block text-center"><button type="button" class="btn btn-primary button-submit">' + buttons[1].text +'</button></div>');
    }
    div.appendChild(head);
    div.appendChild(body);
    div.appendChild(footer);
    section.appendChild(div);
    const close = head.select('.fa-window-close');
    if(close){
        close.on('click', (event) => {
            div.remove();
        });
    }
    const submit = footer.select('.button-submit');
    if(submit){
        submit.on('click', (event) => {
            div.remove();
        });
        submit.focus();
    }
}

export default dialog;