{R3M}
ready(() => {
    const section = select('section[name="{{$controller.name}}"]');
    if(!section){
        console.warn('Cannot find section...');
    }
    const active = section.select('.active');
    if(active){
        active.request();
    }

});
