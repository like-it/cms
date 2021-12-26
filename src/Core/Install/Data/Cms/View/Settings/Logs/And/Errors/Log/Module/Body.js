{R3M}
import { getSectionByName } from "/Module/Section.js";
import user from "/Module/User.js";

ready(() => {
    console.log('body.js')
    const request = JSON.parse(`{{object(request(), 'json')}}`);
    console.log(request);
});
