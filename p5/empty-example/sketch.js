function setup() {
    loadJSON("https://crossorigin.me/https://api.nicehash.com/api?method=stats.provider&addr=32kcrGh8vFHhgNPJdadHnfdNgqxQKqjnZ1", parseResponse, 'jsonp');
}

function parseResponse(data) {

    var object = data;
    println(object);


    var obj = JSON.parse(object);
    console.log(obj);
}

function draw() {
  // put drawing code here
}