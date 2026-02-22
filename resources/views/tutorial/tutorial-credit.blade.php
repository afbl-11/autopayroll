
<x-app title="Technical Guide">

    <div class="links">
        <ul>
            <li><a class="v" href="{{ route('tutorial.tutorial') }}">Admin Dashboard & Settings</a></li>
            <li><a class="v"href="{{ route('tutorial.attendance') }}">Attendance</a></li>
            <li><a class="a"href="{{ route('tutorial.credit') }}">Leave & Credit Management</a></li>
       {{-- <li><a class="v"href="">Employee and Client Management</a></li> --}}
            <li><a class="v" href="{{ route('tutorial.salary') }}">Salary & Tax Management</a></li>
        </ul>
    </div>

    <div class="content">
        <div class="bar">
        <a href="{{ route('tutorial.leave') }}" class="p">Leave Management Guide</a>
        <a href="{{ route('tutorial.credit') }}" class="s">Credit Adjustment Guide</a>
        </div>
        <p class="titles">Credit Adjustment</p>
        <img class="pic1" src="{{ asset('assets/tutorial/credit-3.png') }}" alt="Guide">
        <p class="sentence"><span class="k">T</span>he credit adjustment functionality on the website allows you to apply employee-requested adjustments and either approve or reject them.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/credit-1.png') }}" alt="Guide">
        <p class="sentence">To start, scroll down to the Adjustment Requests in the Admin Dashboard.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/credit-2.png') }}" alt="Guide">
        <p class="sentence">Select a certain adjustment request.</p>
        <br>        
        <img class="pic1" src="{{ asset('assets/tutorial/credit-3.png') }}" alt="Guide">
        <p class="sentence">You will be redirected to the Credit Adjustments Page.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/credit-4.png') }}" alt="Guide">
        <p class="sentence">Select a certain adjustment request here.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/credit-5.png') }}" alt="Guide">
        <p class="sentence">You can see the adjustment request details.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/credit-6.png') }}" alt="Guide">
        <p class="sentence">In this part, you can either Approve or Reject. If you want to reject it just click <b>Reject</b>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/credit-7.png') }}" alt="Guide">
        <p class="sentence">If you want to approve the request, you need to apply first the adjustment. Thus, to get out of the modal, click the shadow part behind the modal. </p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/credit-8.png') }}" alt="Guide">
        <p class="sentence">Select the request and select the adjustment type that will be applied.</p>
        <br>        
        <img class="pic1" src="{{ asset('assets/tutorial/credit-9.png') }}" alt="Guide">
        <p class="sentence">Enter the Log Date Affected and the Time-Out log requested to be adjusted.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/credit-10.png') }}" alt="Guide">
        <p class="sentence">Click <b>Apply</b>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/credit-11.png') }}" alt="Guide">
        <p class="sentence">Go back to the modal and click <b>Approve</b>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/credit-12.png') }}" alt="Guide">
        <p class="sentence">The adjustment has been approved and is not displayed anymore in the Credit Adjustment page.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/credit-13.png') }}" alt="Guide">
        <p class="sentence">However, the status of the adjustment will be displayed in the credit adjustment pages of both the mobile application and the employee website of the system.</p>
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
