
<x-app title="Guide">

    <div class="links">
        <ul>
            <li><a class="a" href="{{ route('tutorial.settings') }}">Admin Dashboard & Settings</a></li>
            <li><a class="v"href="{{ route('tutorial.attendance') }}">Attendance</a></li>
            <li><a class="v"href="">Leave & Credit Management</a></li>
       {{-- <li><a class="v"href="">Employee and Client Management</a></li> --}}
            <li><a class="v" href="{{ route('tutorial.salary') }}">Salary & Tax Management</a></li>
        </ul>
    </div>

    <div class="content">
        <div class="bar">
        <a href="{{ route('tutorial.tutorial') }}" class="p">Dashboard Guide</a>
        <a href="{{ route('tutorial.settings') }}" class="s">Settings Guide</a>
        </div>
        <p class="titles">Settings</p>
        <img class="pic1" src="{{ asset('assets/tutorial/settings-1.png') }}" alt="Guide">
        <p class="sentence"><span class="k">T</span>he settings page allows you to edit your profile information, including your profile picture, name, and company name.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/settings-location.png') }}" alt="Guide">
        <p class="sentence">You can find the settings page by pressing that icon in the sidebar.</p>
        <br>        
        <img class="pic1" src="{{ asset('assets/tutorial/settings-2.png') }}" alt="Guide">
        <p class="sentence">For changing the profile picture, click <b>Change Photo</b>, which will allows you to choose and upload a picture, and click <b>Save Changes</b>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/settings-3.png') }}" alt="Guide">
        <p class="sentence">For changing the profile details, change the displayed information on the input and select dropdown fields, which you inputted during the account and registration, and click <b>Save Changes</b>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/settings-4.png') }}" alt="Guide">
        <p class="sentence">For deleting account, click <b>Delete Account</b>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/settings-5.png') }}" alt="Guide">
        <p class="sentence">A modal will appear that will let you to enter your password first, before pressing <b>Confirm</b> to delete your account.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/settings-6.png') }}" alt="Guide">
        <p class="sentence">For changing the password, click <b>Change Password</b>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/settings-7.png') }}" alt="Guide">
        <p class="sentence">You will be redirected to the Change Password page, where you must enter your current password before your new password. Re-enter the new password in the Confirm Password input field before pressing <b>Confirm</b>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/settings-8.png') }}" alt="Guide">
        <p class="sentence">For changing the company location, click <b>Change Location</b>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/settings-9.png') }}" alt="Guide">
        <p class="sentence">You will be redirected to the Change Location page, where you will input your company's new location through the provided input and select dropdown fields before clicking <b>Change Location</b>.</p>
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
</style>
