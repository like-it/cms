import create from "/Module/Create.js";
import { getSectionByName } from "/Module/Section.js";


let loader = {};

loader.start = ({className, target}) => {
    const section = select("section[name='main-content']");
    if(!section){
        return;
    }
    target = section.select(target);
    if(!target){
        return;
    }
    //card-body h-100 card-body-loader
    const card = create('div',className);
    const spinner = create('div', 'spinner');
    const rect1 = create('div', 'rect1');
    const rect2 = create('div', 'rect2');
    const rect3 = create('div', 'rect3');
    const rect4 = create('div', 'rect4');
    const rect5 = create('div', 'rect5');
    spinner.appendChild(rect1);
    spinner.appendChild(rect2);
    spinner.appendChild(rect3);
    spinner.appendChild(rect4);
    spinner.appendChild(rect5);
    card.appendChild(spinner);
    target.appendChild(card);
}

loader.end = () => {
    //not needed or delete card-body-loader
}

export default loader;