let word1 = document.querySelector(".word1");
let word2 = document.querySelector(".word2");
let word3 = document.querySelector(".word3");
let successMsg = document.querySelector(".success");
let counter = 0;
let home = "http://localhost/Triple-B/index.php";

let limitTime = Math.floor(Math.random() * 9);
console.log(limitTime);

setInterval(() => {
    console.log(counter)
    if(counter === limitTime){
        word1.classList.remove("active");
        word2.classList.remove("active");
        word3.classList.remove("active");
        word1.classList.add("hidden");
        word2.classList.add("hidden");
        word3.classList.add("hidden");
        successMsg.classList.remove("hidden");
        //redirect to different page
        setTimeout(()=>{
            window.location.replace(home);
        }, 1000);
    }
    if(word1.classList.contains("active")){
        word1.classList.toggle("active");
        word2.classList.toggle("active");
        counter++;
        console.log(counter);
    }else if(word2.classList.contains("active")){
        word2.classList.toggle("active");
        word3.classList.toggle("active");
        counter++;
        console.log(counter);
    }else{
        word3.classList.toggle("active");
        word1.classList.toggle("active");
        counter++;
        console.log(counter);
    }
}, 550); //550
