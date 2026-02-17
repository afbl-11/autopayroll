
<x-app title="Guide">

    <div class="links">
        <ul>
            <li><a class="v" href="{{ route('tutorial.tutorial') }}">Admin Dashboard & Settings</a></li>
            <li><a class="a"href="{{ route('tutorial.attendance') }}">Attendance</a></li>
            <li><a class="v"href="">Leave & Credit Management</a></li>
            <li><a class="v"href="">Employee and Client Management</a></li>
            <li><a class="v" href="">Salary & Tax Management</a></li>
        </ul>
    </div>

    <div class="content">
        <a href="{{ route('tutorial.manual-attendance') }}" class="s">Next Page to Manual Attendance Guide</a>
        <p class="titles">Attendance: <i>Pre-Requisite</i></p>
        <img class="pic1" src="{{ asset('assets/tutorial/pre-req_attendance-1.png') }}" alt="Guide">
        <p class="sentence"><span class="k">F</span>irst, in order for your employees to have attendance in the system, you must assign them to a company.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/pre-req_attendance-2.png') }}" alt="Guide">
        <p class="sentence">For full-time and contractual employees, they already have been assigned to a company during registration.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/pre-req_attendance-3.png') }}" alt="Guide">
        <p class="sentence">For part-time employees, they are not assigned to a company upon registration. Thus, you must assign them here by pressing <b>Hire</b>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/pre-req_attendance-4.png') }}" alt="Guide">
        <p class="sentence">For part-time employees, they have flexible schedules since they are placed onto multiple company sites if ever a certain full-time or contractual employee is absent. Thus, their hiring process is per day per site. Select a day for them to be hired in this site by pressing that day and click <b>Confirm Hire</b>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/pre-req_attendance-5.png') }}" alt="Guide">
        <p class="sentence">The part-time employee hired will appear here and in what day they will be working in the company.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/pre-req_attendance-6.png') }}" alt="Guide">
        <p class="sentence">It is important to note that after hiring them, it will display their available days. This indicates that when you are going to assign them to another company, you will be notified about what days are not yet assigned to them.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/pre-req_attendance-7.png') }}" alt="Guide">
        <p class="sentence">Second, assign them a schedule in the company.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/pre-req_attendance-8.png') }}" alt="Guide">
        <p class="sentence">Click the employee you want to assign their schedule with. Select their working days in the company by selecting the day cards.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/pre-req_attendance-9.png') }}" alt="Guide">
        <p class="sentence">Next, input their start and end time for their working hours in the site.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/pre-req_attendance-10.png') }}" alt="Guide">
        <p class="sentence">Lastly, click <b>Save Schedule</b>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/pre-req_attendance-11.png') }}" alt="Guide">
        <p class="sentence">The inputted schedule of the employees will be displayed here. This schedule is integral in timing-in and timing-out using the QR system in the mobile application and as well in recording attendance logs in this website.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/pre-req_attendance-12.png') }}" alt="Guide">
        <p class="sentence">For part-time employees, same process will be applied if they were selected. However, since in their hiring process the working days have already been selected. It will be fixed here.</p>
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
    font-size: 25px;
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
.s {
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
    margin-left: auto;
    font-size: 13px;
}
.s:hover {
    transition: 0.3s ease-out;
    color: gray;
}
</style>
