 async function register(){
    const firstname=document.getElementById('FirstName').value;
    const  Lastname=document.getElementById('LastName').value;
    const  email=document.getElementById('Email').value;
    const password = document.getElementById('Password').value;
      const data = {
              "firstname": firstname,
            "lastname": Lastname,
             "email": email,
            "pass": password,
     };
    url='http://localhost/website/sign_up/backend/api/signup.php';
    const response=await fetch(url,{
        method:'POST',
        headers:{'Content-Type':'application/json'},
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