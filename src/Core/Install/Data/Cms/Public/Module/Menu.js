let menu = {};

menu.dispatch = (data) => {
    if(
        is.array(data?.select)
    ){
        let index;
        for(index=0; index < data.select.length; index++){
            let item = data.select[index];
            if(
                item?.name &&
                item?.event
            ){
                const menuItem = section.select(item.name);
                if(menuItem){
                    if(
                        item?.hidden
                    ){
                        menuItem.data('is-hidden', item?.hidden);
                    }
                    menuItem.dispatchEvent(item.event);
                }
            }
        }
    } else {
        if(
            data?.select &&
            data?.event
        ){
            const menuItem = section.select(data.select);
            if(menuItem){
                if(
                    data?.hidden
                ){
                    menuItem.data('is-hidden', data?.hidden);
                }
                menuItem.dispatchEvent(data.event);
            }
        }
    }
}

export default menu;