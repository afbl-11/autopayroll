
<x-app title="Technical Guide">

    <div class="links">
        <ul>
            <li><a class="a" href="{{ route('tutorial.tutorial') }}">Admin Dashboard & Settings</a></li>
            <li><a class="v"href="{{ route('tutorial.attendance') }}">Attendance</a></li>
            <li><a class="v"href="{{ route('tutorial.leave') }}">Leave & Credit Management</a></li>
            <li><a class="v"href="{{ route('tutorial.client') }}">Employee and Client Management</a></li>
            <li><a class="v" href="{{ route('tutorial.salary') }}">Salary & Tax Management</a></li>
        </ul>
    </div>

    <div class="content">
        <div class="bar">
        <a href="{{ route('tutorial.tutorial') }}" class="p">Dashboard Guide</a>
        <a href="{{ route('tutorial.settings') }}" class="s">Settings Guide</a>
        </div>
        <p class="titles">Dashboard</p>
        <img class="pic1" src="{{ asset('assets/tutorial/admin_dashboard.png') }}" alt="Guide">
        <p class="sentence"><span class="k">T</span>he dashboard page presents the summary of the overall operations of the registered company, including the total number of employees, overall payroll costs, and manpower distribution. <br> <br> <i>Note: It is also the first page you will see upon logging in into this website.</i></p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/requests.png') }}" alt="Guide">
        <p class="sentence">In addition, it also displays the pending requests submitted by employees.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/highlighted-requests.png') }}" alt="Guide">
        <p class="sentence">These requests are clickable, which can redirect you to the details of those specified requests for approval.</p>
        <br>
        <div id="imageModal" class="image-modal">
            <span class="close-modal">&times;</span>
            <div class="zoom-container">
                <img id="modalImage">
            </div>
        </div> 
    </div>

</x-app>
<style>
.links {
    border-radius: 0;
    background-color: #FFD858;
    display: flex;
    justify-content: center;   
    align-items: center;   
    width: 92%;
    border-radius: 16px;
    align-self: center;
    margin-bottom: 50px;
    height: 70px;
}
.bar {
    display: flex;
    justify-content: flex-end;
}
.links ul{
    display: flex;
    gap: 50px;
}
.links ul li{
    list-style: none;
}
.links a {
    font-size: 14px;
    letter-spacing: 1.33px;
    padding: 10px;
    text-decoration: none;
}
.v {
    color: black;
    transition: 0.3s ease-out;
    border-radius: 16px;
}
.a {
    background-color: black;
    color: #FFD858;
    border-radius: 16px;
    transition: 0.3s ease-out;
}
.a:hover {
    color: #fee283;
    background-color: #282828;
}
.v:hover {
    background-color: black;
    color: #FFD858;
}
.titles {
    margin-top: 0px;
    font-size: 20px;
    letter-spacing: 1.33px;
    border-bottom: 1px solid lightgray;
}
.last {
    color: #FFD858;
}
.content {
    width: 70%;
    margin-bottom: 35px;
    padding: 50px;
    border-left: lightgray 1px solid;
    border-right: lightgray 1px solid;
    border-bottom: lightgray 1px solid;
    border-top: lightgray 1px solid;
    padding-top: 35px;

}
.pic1, .pic2 {
   width: 800px;  
   margin-top: 25px;
   margin-bottom: 25px;
   align-self: center;
   margin-left: auto;
   margin-right: auto;
   display: block;
   border: 1px lightgray solid;
   padding: 8px;
}
.pic2 {
    width: 600px
}
.k {
    font-size: 28px;
}
.sentence {
    text-align: justify;
    margin-bottom: 15px;
    width: 85%;
    margin-left: 7%;
}
.sentences {
    text-align: center;
    margin-bottom: 15px;
}
.s, .p {
    padding: 2px;
    padding-left: 10px;
    border-left: 1px solid lightgray;
    letter-spacing: 1.33px;
    color: black;
    text-decoration: none;
    display: block;
    text-align: right;
    width: fit-content;
    margin-bottom: 25px;
    font-size: 13px;
}
.s:hover, .p:hover {
    transition: 0.3s ease-out;
    color: gray;
}
.p {
    border-left: 0px solid lightgray;
    padding-right: 10px;
    padding-left: 0px;
}
@media (max-width: 1300px) {
    .pic1 {
        width: 600px;
    }
    .links a {
        font-size: 12px;
    }
    .links, .content {
        margin-left: 25px;
    }
}

@media (max-width: 1100px) {
    .pic1 {
        width: 500px;
    }
    .links ul{
        gap: 30px;
    }
    .links a {
        font-size: 11px;
    }
    .links, .content {
        margin-left: 45px;
    }
}

@media (max-width: 950px) {
    .pic1 {
        width: 100%;
    }    
}

@media (max-width: 900px) {
    .links {
        width: 85%;
        text-align: center;
    }
    .links a {
        padding: 5px;
    }
}

@media (max-width: 700px) {
    .links {
        width: 82%;
        text-align: center;
    }
    .links ul{
        gap: 20px;
    }
    .links a {
        font-size: 10px;
    }
    .links, .content {
        margin-left: 75px;
    }
    .s, .p {
        font-size: 11px;
    }
}
@media (max-width: 675px) {
    .links {
        width: 75%;
        text-align: center;
        display: flex;
        flex-direction: column;
        height: auto;
    }
    .links ul{
        flex-direction: column;
        gap: 8px;
        align-items: center;
        margin-top: 10px;
        margin-bottom: 10px;
    }
    .links a {
        font-size: 12px;
    }
}
@media (max-width: 480px) {
    .links a {
        font-size: 10px;
    }    
    .links {
        width: 70%;
    }
    .content {
        width: 65%;
    }
    .bar {
        margin-right: -25px;
    }
}
.image-modal {
    display: none;
    position: fixed;
    z-index: 9999;
    inset: 0;
    background: rgba(0,0,0,0.9);
}

.zoom-container {
    width: 100%;
    height: 100%;
    overflow: hidden;
    cursor: grab;
    display: flex;
    align-items: center;
    justify-content: center;
}

#modalImage {
    max-width: 90%;
    max-height: 90%;
    transition: transform 0.1s ease-out;
    transform-origin: center center;
}

.close-modal {
    position: absolute;
    top: 20px;
    right: 35px;
    font-size: 40px;
    color: white;
    cursor: pointer;
}
</style>

<script>
const modal = document.getElementById("imageModal");
const modalImg = document.getElementById("modalImage");
const zoomContainer = document.querySelector(".zoom-container");
const closeBtn = document.querySelector(".close-modal");

let scale = 1;
let posX = 0;
let posY = 0;
let isDragging = false;
let startX, startY;

document.querySelectorAll(".pic1, .pic2").forEach(img => {
    img.addEventListener("click", function() {
        modal.style.display = "block";
        modalImg.src = this.src;
        scale = 1;
        posX = 0;
        posY = 0;
        modalImg.style.transform = `translate(0px, 0px) scale(1)`;
    });
});

closeBtn.onclick = () => modal.style.display = "none";

modal.onclick = e => {
    if (e.target === modal) modal.style.display = "none";
};

zoomContainer.addEventListener("wheel", function(e) {
    e.preventDefault();

    const rect = modalImg.getBoundingClientRect();
    const offsetX = e.clientX - rect.left;
    const offsetY = e.clientY - rect.top;

    const zoom = e.deltaY < 0 ? 1.1 : 0.9;
    scale *= zoom;

    posX -= (offsetX - rect.width / 2) * (zoom - 1);
    posY -= (offsetY - rect.height / 2) * (zoom - 1);

    modalImg.style.transform =
        `translate(${posX}px, ${posY}px) scale(${scale})`;
});

zoomContainer.addEventListener("mousedown", function(e) {
    isDragging = true;
    startX = e.clientX - posX;
    startY = e.clientY - posY;
    zoomContainer.style.cursor = "grabbing";
});

zoomContainer.addEventListener("mousemove", function(e) {
    if (!isDragging) return;
    posX = e.clientX - startX;
    posY = e.clientY - startY;
    modalImg.style.transform =
        `translate(${posX}px, ${posY}px) scale(${scale})`;
});

zoomContainer.addEventListener("mouseup", function() {
    isDragging = false;
    zoomContainer.style.cursor = "grab";
});

zoomContainer.addEventListener("mouseleave", function() {
    isDragging = false;
    zoomContainer.style.cursor = "grab";
});
</script>