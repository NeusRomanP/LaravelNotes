
require('./bootstrap');

const { default: axios } = require('axios');

let user=document.getElementById("user");
let editButton=document.getElementById("submitEdit");
//console.log(user);
user.addEventListener("input", getUsers);
let shared_users=[];
let users_list=[];

function getUsers(){
    let location=window.location.href.split("/")
    //console.log(location[location.length-1]);
    if(user.value.trim()!=""){
        let formData = new FormData();
        formData.append("users[]", shared_users);
        axios.post('/notes/'+location[location.length-1]+"/"+user.value, {
            note : location[location.length-1],
            user: user.value,
            shared: shared_users
          })
          .then((resp)=>{
                //console.log(resp);
                let users_container=document.getElementById("users-container");
                if(users_container.hasChildNodes()){
                    users_container.innerHTML="";
                }
                if(document.getElementById)
                resp.data.forEach(res => {
                    const element = document.createElement("div");
                    const node = document.createTextNode(res.name);
                    element.className="suggested-user";
                    element.appendChild(node);
                    users_container.appendChild(element);
                    element.addEventListener("click", function(){
                        shared_users.push(element.innerHTML);
                        addSharedUser(element.innerHTML);
                        if(users_container.hasChildNodes()){
                            users_container.innerHTML="";
                        }
                    })
                });
                
           
          })
          .catch(function (error) {
            console.log(error);
          })
    }
}

function addSharedUser(sharedUser){
    let shared_users_container = document.getElementById("users-to-share-with");
    const element = document.createElement("div");
    let shared_user_span = document.createElement("span");
    const node = document.createTextNode(sharedUser);
    let removeElement= document.createElement("span");
    let removeElementNode= document.createTextNode("Remove");
    removeElement.classList.add("remove-element");
    element.className="shared-user";
    removeElement.appendChild(removeElementNode);
    shared_user_span.appendChild(node);
    element.appendChild(shared_user_span);
    element.appendChild(removeElement);
    shared_users_container.appendChild(element);

    removeElement.addEventListener("click", function(){
        shared_users.splice(shared_users.indexOf(sharedUser), 1);
        element.remove();
    });

    console.log(shared_users);
}

document.addEventListener("click", function(event){
    let users_container=document.getElementById("users-container");
    //console.log(event.target.id);
    if(event.target.id!=user && !event.target.classList.contains("suggested-user")){
        if(users_container.hasChildNodes()){
            users_container.innerHTML="";
        }
    }
    
})

editButton.addEventListener("click", function(){
    let location=window.location.href.split("/")
    let myForm = document.getElementById('myForm');
    let formData= new FormData();
    formData.append("prova", "prova");
    //formData.append('_method', 'POST');
    for (var i = 0; i < shared_users.length; i++) {
        formData.append("users[]", shared_users[i]);
    }
    formData.append("note", location[location.length-1]);
    console.log(location);
    console.log('/notes/'+location[location.length-1]);
    axios.post('/notes/'+location[location.length-1], {
        note: location[location.length-1],
        title: document.getElementById("title").value,
        content: document.getElementById("content").value,
        users: shared_users
      })
      .then((resp)=>{
        window.location.reload();
      })
      .catch(function (error) {
        console.log(error);
      })
})