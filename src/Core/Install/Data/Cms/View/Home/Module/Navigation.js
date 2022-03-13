//{{R3M}}
import { getSectionByName} from "/Module/Section.js";

ready(() => {
    const navigation = getSectionByName("navigation");
    if(!navigation){
        request("{{route.get(route.prefix() + '-navigation-main')}}");
    }
});
