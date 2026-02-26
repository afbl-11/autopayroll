
<x-app title="Technical Guide">

    <div class="links">
        <ul>
            <li><a class="v" href="{{ route('tutorial.tutorial') }}">Admin Dashboard & Settings</a></li>
            <li><a class="v"href="{{ route('tutorial.attendance') }}">Attendance</a></li>
            <li><a class="v"href="{{ route('tutorial.leave') }}">Leave & Credit Management</a></li>
            <li><a class="a"href="{{ route('tutorial.client') }}">Employee and Client Management</a></li>
            <li><a class="v" href="{{ route('tutorial.salary') }}">Salary & Tax Management</a></li>
        </ul>
    </div>

    <div class="content">
        <div class="bar">
        <a href="{{ route('tutorial.client') }}" class="p">Client Management Guide</a>
        <a href="{{ route('tutorial.employee') }}" class="s">Employee Management Guide</a>
        </div>
        <p class="titles">Client Management</p>
        <img class="pic1" src="{{ asset('assets/tutorial/client-1.png') }}" alt="Guide">
        <p class="sentence"><span class="k">T</span>o start, let us add company clients to the system. Thus, click that icon.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/client-2.png') }}" alt="Guide">
        <p class="sentence">You will be redirected to the Company Dashboard Page.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/client-3.png') }}" alt="Guide">
        <p class="sentence">Afterwards, click <b>Add Company</b>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/client-4.png') }}" alt="Guide">
        <p class="sentence">You will be redirected to the Client Registration Page.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/client-5.png') }}" alt="Guide">
        <p class="sentence">Click <b>Add Logo</b> to add a logo for your client company.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/client-6.png') }}" alt="Guide">
        <p class="sentence">You will need to input the client company’s information to these input fields.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/client-7.png') }}" alt="Guide">
        <p class="sentence">If you’re done, click <b>Add Client</b>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/client-8.png') }}" alt="Guide">
        <p class="sentence">You will be redirected to this page, which is needed for the QR attendance functionality of the system. This can be done by selecting the location of the client site in the map and input the radius of the area.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/client-9.png') }}" alt="Guide">
        <p class="sentence">Afterwards, click <b>Confirm</b>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/client-10.png') }}" alt="Guide">
        <p class="sentence">You will be redirected to this page, which you can review first the details you inputted before clicking <b>Create Client</b> to create the integrate the client company in the system.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/client-11.png') }}" alt="Guide">
        <p class="sentence">Subsequently, you will be redirected to the admin page, repeat back again to the first step to be redirected to the Company Dashboard page. As you can see, your company has been created. Click your created Company.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/client-12.png') }}" alt="Guide">
        <p class="sentence">You will be redirected to the Company Information tab of your client company’s page, which displays the information you had registered for this company site including the latitude and longitude of the location using the inputted radius during onboarding.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/client-13.png') }}" alt="Guide">
        <p class="sentence">Click <b>Edit Profile</b> to edit the Company’s information.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/client-14.png') }}" alt="Guide">
        <p class="sentence">You will be redirected to the Edit Company page, which allows you to change the company’s logo and company information. It also encapsulates the same process during registration.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/client-15.png') }}" alt="Guide">
        <p class="sentence">Nonetheless, if you had any changes here just click <b>Save</b> to save the changes. </p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/client-16.png') }}" alt="Guide">
        <p class="sentence">You can delete your created company client as well by clicking <b>Delete Company</b>. However, if full-time and contractual employees are assigned here, it will restrict this option.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/client-17.png') }}" alt="Guide">
        <p class="sentence">The Employees and Schedules tab guide will be tackled in the Employee Assignment Guide in the Attendance Guide Tab. Thus, click <b>QR Management</b> to see the created QR of the system. </p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/client-18.png') }}" alt="Guide">
        <p class="sentence">This tab will display the created QR of the system based on the registered location. You can click <b>Download QR Code</b> to download the QR to be used in the client company’s site area for the attendance purposes using the Attendance QR System of the Mobile Application.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/client-19.png') }}" alt="Guide">
        <p class="sentence">After that, click <b>Location</b>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/client-20.png') }}" alt="Guide">
        <p class="sentence">This page is used for changing the location of the client company site, which will also affect the location registered in the QR code for this company site. By doing the same process as before in registering the location of the company, you can change the location of the company site.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/client-21.png') }}" alt="Guide">
        <p class="sentence">Now, if you had any changes here, click <b>Confirm</b> to update the location. </p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/client-22.png') }}" alt="Guide">
        <p class="sentence">As you can see, it will display the updated address along with its updated latitude and longitude using the updated radius.</p>
        <br>
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
</style>
