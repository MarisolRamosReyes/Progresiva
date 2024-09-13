let swLocation ="sw.js";

if(navegator.serviceWorker){
    if(window.location.href.includes("localhost")) swLocation="/sw.js";
    navigator.serviceWorker.register(swLocation);
}