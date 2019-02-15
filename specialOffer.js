window.addEventListener('load', () =>{
    'use strict'

    const requestURL = 'getOffers.php';
    const requestXMLURL = 'getOffers.php?xml';

    const offers = document.getElementById('offers');
    const xmlOffers = document.getElementById('XMLoffers');
    let timer = setInterval(newOfferTimer, 5000);

    function newOfferTimer() {
        getRequest(requestURL, updateHTMLTarget);
    }

    function getRequest(url, callback){
        const httpRequest = new XMLHttpRequest();

        httpRequest.onreadystatechange = () => {
            let completed = 4, successful = 200;

            if(httpRequest.readyState == completed){
                if(httpRequest.status == successful){
                    callback(httpRequest.responseText);
                }else{
                    alert('There was a problem with the request');
                }
            }
        };
        httpRequest.open('get', url, true);
        httpRequest.send(null);
    }

    function updateHTMLTarget(text){
        offers.innerHTML = text;
    }

    function updateXMLTarget(text){
        const parser = new DOMParser();

        let xmlDoc;

        try{
            xmlDoc = parser.parseFromString(text, 'text/xml');
        }catch(error){
            getRequest(requestXMLURL, updateXMLTarget);
            return;
        }

        const nodeName = xmlDoc.documentElement.nodeName === 'parseerror' ? 'error while parsing'
                : xmlDoc.documentElement.nodeName;


        const record = xmlDoc.getElementsByTagName(nodeName)[0].innerHTML;


        xmlOffers.innerHTML = "<p>" + record + "</p>";

    }

    getRequest(requestURL, updateHTMLTarget);
    getRequest(requestXMLURL, updateXMLTarget);
    timer;

});