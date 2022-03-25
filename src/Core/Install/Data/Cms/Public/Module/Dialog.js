import create from "/Module/Create.js";

let dialog = {};

dialog.create = ({
    title,
    message,
    error,
    buttons,
    section,
    className,
    form,
    submit
}) => {
    if(is.empty(className)){
        className = 'dialog';
    }
    const div = create('div', className);
    const element = create('form');
    element.attribute('name', form?.name);
    if(form?.method){
        element.attribute('method', form.method);
    } else {
        element.attribute('method', 'POST');
    }
    element.data('url', form?.url);
    const head = create('div', 'head');
    const body = create('div', 'body');
    const footer = create('div', 'footer');
    head.html('<h1>' + title + '</h1><span class="close"><i class="fas fa-window-close"></i></span>');
    console.log(error);
    if(error?.length > 0){
        body.html('<p class="alert alert-danger">' + error.join('<br>')  + '</p>');
    }
    if(message.substring(0,1) === '<' && message.substring(-1,1) === '>'){
        body.html(body.html() + message);
    } else {
        body.html(body.html() + '<p>' + message  + '</p>');
    }
    if(buttons.length === 1){
        footer.html('<div class="w-100 d-inline-block text-center"><button type="submit" class="btn btn-primary button-submit">' + buttons[0].text +'</button></div>');
    }
    else if (buttons.length === 2){
        footer.html('<div class="w-50 d-inline-block text-center"><button type="submit" class="btn btn-primary button-submit">' + buttons[0].text +'</button></div><div class="w-50 d-inline-block text-center"><button type="button" class="btn btn-primary button-cancel">' + buttons[1].text +'</button></div>');
    }
    element.append(head);
    element.append(body);
    element.append(footer);
    div.appendChild(element);
    section.appendChild(div);
    const close = head.select('.fa-window-close');
    if(close){
        close.on('click', (event) => {
            div.remove();
        });
    }
    const cancel = footer.select('.button-cancel');
    if(cancel){
        cancel.on('click', (event) => {
            div.remove();
        });
    }
    if(submit !== false){
        submit = footer.select('.button-submit');
        if(submit){
            submit.on('click', (event) => {
                div.remove();
            });
            submit.focus();
        }
    }
    element.on('submit', (event) => {
        event.preventDefault();
    });
    return div;
}

export default dialog;