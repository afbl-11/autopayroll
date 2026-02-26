
<x-app title="Technical Guide">

    <div class="links">
        <ul>
            <li><a class="v" href="{{ route('tutorial.tutorial') }}">Admin Dashboard & Settings</a></li>
            <li><a class="v"href="{{ route('tutorial.attendance') }}">Attendance</a></li>
            <li><a class="v"href="{{ route('tutorial.leave') }}">Leave & Credit Management</a></li>
            <li><a class="a"href="{{ route('tutorial.employee') }}">Employee and Client Management</a></li>
            <li><a class="v" href="{{ route('tutorial.salary') }}">Salary & Tax Management</a></li>
        </ul>
    </div>

    <div class="content">
        <div class="bar">
        <a href="{{ route('tutorial.client') }}" class="p">Client Management Guide</a>
        <a href="{{ route('tutorial.employee') }}" class="s">Employee Management Guide</a>
        </div>
        <p class="titles">Employee Management</p>
        <img class="pic1" src="{{ asset('assets/tutorial/employee-1.png') }}" alt="Guide">
        <p class="sentence"><span class="k">T</span>o start, let us add an employee. Click that icon.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/employee-2.png') }}" alt="Guide">
        <p class="sentence">You will be redirected to the Employee Dashboard page.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/employee-3.png') }}" alt="Guide">
        <p class="sentence">Click <b>Add Employee</b>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/employee-4.png') }}" alt="Guide">
        <p class="sentence">You will be redirected to the Add Employee page.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/employee-5.png') }}" alt="Guide">
        <p class="sentence">Input their personal details in the input fields. 
        <br> <br>
        <i>Note: Inputting middle names and suffixes are optional and birth date must correspond to 18 years old and above. The names of the employees are validated by first, middle, and last name for similarities.</i>
        </p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/employee-6.png') }}" alt="Guide">
        <p class="sentence">Input also their bank account number and statutory benefit numbers. 
        <br> <br>
        <i>Note: The input fields also validated for similarities in terms of statutory benefit numbers of other employees.</i>
        </p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/employee-7.png') }}" alt="Guide">
        <p class="sentence">If you are finished inputting the employee’s personal details, click <b>Continue</b>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/employee-8.png') }}" alt="Guide">
        <p class="sentence">Input their residential address and contact information in the provided select dropdown and input fields.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/employee-9.png') }}" alt="Guide">
        <p class="sentence">Input their Address on ID, which is their current residential address.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/employee-10.png') }}" alt="Guide">
        <p class="sentence">If it is the same as your residential address, select the checkbox.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/employee-11.png') }}" alt="Guide">
        <p class="sentence">If you are done in inputting their residential and contact addresses, click <b>Continue</b>. </p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/employee-12.png') }}" alt="Guide">
        <p class="sentence">Click first the employment type and input their Daily Rate. If you select <b>Full-Time</b> in their employment type, you must need to input the company that you would assign them to and their starting date.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/employee-13.png') }}" alt="Guide">
        <p class="sentence">Same applies if you select <b>Contractual</b>, but the difference is that you will need to input their termination date.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/employee-14.png') }}" alt="Guide">
        <p class="sentence">If you selected <b>Part-Time</b>, you must select the Days Available upon working for your company that you would use in assigning them to multiple companies.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/employee-15.png') }}" alt="Guide">
        <p class="sentence">After selecting their employment type and input their daily rate, input their position and upload their documents (optional).</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/employee-16.png') }}" alt="Guide">
        <p class="sentence">If you’re done, click <b>Continue</b>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/employee-17.png') }}" alt="Guide">
        <p class="sentence">Input their username and screenshot their email and password, that you will send it to them in order for the created account to be accessed by them, before clicking <b>Continue</b>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/employee-18.png') }}" alt="Guide">
        <p class="sentence">Subsequently, you will redirected to this page that will allow you to review the inputted details.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/employee-19.png') }}" alt="Guide">
        <p class="sentence">Afterwards, if done, click <b>Create Employee</b>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/employee-20.png') }}" alt="Guide">
        <p class="sentence">Locate again to the Employee Dashboard and you will see your created employee. Now, Click it. </p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/employee-21.png') }}" alt="Guide">
        <p class="sentence">After clicking it, you will be redirected to the Personal Information tab of the created Employee’s page. </p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/employee-22.png') }}" alt="Guide">
        <p class="sentence">If you want to edit certain categories of their information, click the <b>Edit</b> button encapsulating their card.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/employee-23.png') }}" alt="Guide">
        <p class="sentence">You will be redirected to their specified edit pages. To edit, you can change the displayed information on the input or select dropdown fields before clicking <b>Save</b> for it to be updated in the system. </p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/employee-24.png') }}" alt="Guide">
        <p class="sentence">Click <b>Attendance</b>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/employee-25.png') }}" alt="Guide">
        <p class="sentence">In this tab, it will display their attendance information and logs.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/employee-26.png') }}" alt="Guide">
        <p class="sentence">The attendance logs will look like this, if they will have one.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/employee-27.png') }}" alt="Guide">
        <p class="sentence">Click <b>Leave Request</b>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/employee-28.png') }}" alt="Guide">
        <p class="sentence">This will store their leave request history. Next, click <b>Payroll</b>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/employee-29.png') }}" alt="Guide">
        <p class="sentence">This tab will generate the payroll of the employee per daily log, you can also download it by clicking <b>Download PDF</b>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/employee-30.png') }}" alt="Guide">
        <p class="sentence">To generate payslip, select first the year and month.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/employee-31.png') }}" alt="Guide">
        <p class="sentence">Afterwards, click <b>Generate Payslip</b>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/employee-32.png') }}" alt="Guide">
        <p class="sentence">A modal will appear that will allow you to select a certain payroll period before clicking <b>Continue</b>, which will allow you to view the payslip for that specified period.</p>
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
