let word1 = document.querySelector(".word1");
let word2 = document.querySelector(".word2");
let word3 = document.querySelector(".word3");
let successMsg = document.querySelector(".success");
let counter = 0;
let home = "../../index.html";



setInterval(() => {
    console.log(counter)
    if(word1.classList.contains("active")){
        word1.classList.toggle("active");
        word2.classList.toggle("active");
    }else if(word2.classList.contains("active")){
        word2.classList.toggle("active");
        word3.classList.toggle("active");
    }else if(counter === 1){
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
    }else{
        word3.classList.toggle("active");
        word1.classList.toggle("active");
        counter++;
    }
}, 550);