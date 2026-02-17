
<x-app title="Guide">

    <div class="links">
        <ul>
            <li><a class="v" href="{{ route('tutorial.tutorial') }}">Admin Dashboard & Settings</a></li>
            <li><a class="a"href="{{ route('tutorial.manual-attendance') }}">Attendance</a></li>
            <li><a class="v"href="">Leave & Credit Management</a></li>
            <li><a class="v"href="">Employee and Client Management</a></li>
            <li><a class="v" href="">Salary & Tax Management</a></li>
        </ul>
    </div>

    <div class="content">
        <a href="{{ route('tutorial.attendance') }}" class="s">Back to Pre-Requisite Guide</a>
        <p class="titles">Manual Attendance</p>
        <img class="pic1" src="{{ asset('assets/tutorial/manual_attendance-1.png') }}" alt="Guide">
        <p class="sentence"><span class="k">T</span>he manual attendance feature functions as an alternative version of the Attendance QR Attendance Process of the system.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/manual_attendance-2.png') }}" alt="Guide">
        <p class="sentence">First, in order to operate, select a company. </p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/manual_attendance-3.png') }}" alt="Guide">
        <p class="sentence">It will display the employees assigned to that company. Select <b>Create Date</b> to record the attendance of the employees in a particular date.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/manual_attendance-4.png') }}" alt="Guide">
        <p class="sentence">Subsequently, it will display a modal, which will allow you to input the details of that date.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/manual_attendance-5.png') }}" alt="Guide">
        <p class="sentence">Click <b>Create Date</b>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/manual_attendance-6.png') }}" alt="Guide">
        <p class="sentence">Afterwards, it will display Create Mode.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/manual_attendance-7.png') }}" alt="Guide">
        <p class="sentence">Click the Status buttons to unlock the Time-in and Time-out input fields. After entering the employees’ attendance data on the specified input fields, click <b>Save All</b>. <br> <br> <i>Note: Absent and Day Off are excluded for the input fields to be activated.</i></p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/manual_attendance-8.png') }}" alt="Guide">
        <p class="sentence">It will display here the attendance data created on that particular date.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/manual_attendance-9.png') }}" alt="Guide">
        <p class="sentence">Select a date in the Select Date dropdown field here.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/manual_attendance-10.png') }}" alt="Guide">
        <p class="sentence">Click <b>Edit</b>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/manual_attendance-11.png') }}" alt="Guide">
        <p class="sentence">It will display Edit Mode and the process will be the same as the Create Date. The only difference of this mode is that it will edit the attendance data of the employee inputted on that particular date. <br> <br> <i>Note: typing the time-in and time-out data of a certain employee can automatically maneuver the status buttons, if there attendance data is committing undertime and overtime</i>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/manual_attendance-12.png') }}" alt="Guide">
        <p class="sentence">Select a date in the Select Date dropdown field and click <b>Delete Date</b>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/manual_attendance-13.png') }}" alt="Guide">
        <p class="sentence">It will display an alert box, indicating that if you wanted to delete that particular date with your employees’ attendance data.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/manual_attendance-14.png') }}" alt="Guide">
        <p class="sentence">If you press <b>Ok</b>, the attendance data of those employees on that particular date will be removed.</p>
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
.s {
    padding: 2px;
    padding-right: 10px;
    border-right: 1px solid lightgray;
    letter-spacing: 1.33px;
    color: black;
    text-decoration: none;
    display: block;
    text-align: right;
    width: fit-content;
    margin-bottom: 25px;
    margin-right: auto;
    font-size: 13px;
}
.s:hover {
    transition: 0.3s ease-out;
    color: gray;
}
</style>
