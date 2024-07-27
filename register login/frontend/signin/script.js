async function login(){
    const email=document.getElementById('email').value;
    const password=document.getElementById('password').value;
    const data={
        "email":email,
        "password":password
    };
    url='http://localhost/website/sign_up/backend/api/signin.php';
    const response=await fetch(url,{
        method:"POST",
        headers:{"Content-Type":"application/json"},
        body:JSON.stringify(data),
    })
    
    const data_2=await response.json();
    if(data_2.status=true){
        document.getElementById('result').style.display = 'block';
        document.getElementById('text').innerText = data_2.message;
    }
   
}
function hide(){
    const card=document.getElementById('result');
    card.style.display="none";
}

