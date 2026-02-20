
<x-app title="Guide">

    <div class="links">
        <ul>
            <li><a class="v" href="{{ route('tutorial.settings') }}">Admin Dashboard & Settings</a></li>
            <li><a class="v"href="{{ route('tutorial.attendance') }}">Attendance</a></li>
            <li><a class="v"href="">Leave & Credit Management</a></li>
       {{-- <li><a class="v"href="">Employee and Client Management</a></li> --}}
            <li><a class="a" href="{{ route('tutorial.tax') }}">Salary & Tax Management</a></li>
        </ul>
    </div>

    <div class="content">
        <div class="bar">
        <a href="{{ route('tutorial.salary') }}" class="p">Salary Management Guide</a>
        <a href="{{ route('tutorial.tax') }}" class="s">Tax Management Guide</a>
        </div>
        <p class="titles">Tax Management</p>
        <img class="pic1" src="{{ asset('assets/tutorial/tax-1.png') }}" alt="Guide">
        <p class="sentence"><span class="k">T</span>he Tax Management feature is used to update tax and deduction rates, especially when the government implements changes during a specific period.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/tax-2.png') }}" alt="Guide">
        <p class="sentence">You can find the Deduction Settings page, which is the page utilized for this feature, by pressing first that icon in the sidebar.</p>
        <br>        
        <img class="pic1" src="{{ asset('assets/tutorial/tax-3.png') }}" alt="Guide">
        <p class="sentence">The icon will expand the sidebar. Scroll down and select <b>Tax & Deductions</b>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/tax-4.png') }}" alt="Guide">
        <p class="sentence">To start, you may edit the Withholding Tax by selecting <b>Income Tax</b>, which will redirect you to its dedicated tab. However, this step may not be necessary because when you are redirected to the Deduction Settings page, the tab is automatically displayed.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/tax-5.png') }}" alt="Guide">
        <p class="sentence">Click <b>Clone to New Draft</b> to create the new law version involving Withholding Tax.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/tax-6.png') }}" alt="Guide">
        <p class="sentence">This notification will be displayed to notify that you are going to integrate a new Tax Law Version to edit or update the calculations for the Withholding Tax.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/tax-7.png') }}" alt="Guide">
        <p class="sentence">Scroll down to Full Bracket Reference and edit the monthly taxable income range, base tax, excess over, and rate in accordance with the new law.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/tax-8.png') }}" alt="Guide">
        <p class="sentence">Edit the Version Name, Effective Date, and Status set to <b>Active</b> for it to be used in the payroll. </p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/tax-9.png') }}" alt="Guide">
        <p class="sentence">Scroll down again to Full Bracket Reference and Click <b>Save All Changes</b>.</p>
        <br>        
        <img class="pic1" src="{{ asset('assets/tutorial/tax-10.png') }}" alt="Guide">
        <p class="sentence">It will display a notification that the Tax Configuration has been updated successfully and the created law version will be displayed in the configuration history.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/tax-11.png') }}" alt="Guide">
        <p class="sentence">Use the Tax Simulator to determine if the Withholding Tax has been updated.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/tax-12.png') }}" alt="Guide">
        <p class="sentence">You can also edit the created law version by just simply inputting the updated ranges, rate, taxes in these input fields and click Save All Changes.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/tax-13.png') }}" alt="Guide">
        <p class="sentence">Same will be applied in the fields of the Tax Law Version if there were changes.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/sss-1.png') }}" alt="Guide">
        <p class="sentence">For editing the SSS, click <b>SSS</b> to switch the tab.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/sss-2.png') }}" alt="Guide">
        <p class="sentence">To edit the SSS, download the template first.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/sss-3.png') }}" alt="Guide">
        <p class="sentence">The template will be used to edit the Full Bracket Reference that is found upon scrolling down.</p>
        <br>        
        <img class="pic1" src="{{ asset('assets/tutorial/sss-4.png') }}" alt="Guide">
        <p class="sentence">After downloading the template, you will receive an excel file with a format for the changes inside.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/sss-5.png') }}" alt="Guide">
        <p class="sentence">Input in the file the updated range of compensation, monthly salary credit, and EC (ER).</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/sss-6.png') }}" alt="Guide">
        <p class="sentence">Upload the file containing the updated values. Also, update the version name or the law associated with the changes, set the effective date for system integration, and input the updated employee and employer share.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/sss-7.png') }}" alt="Guide">
        <p class="sentence">Click <b>Upload and Activate Rate</b> to upload it in the system.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/sss-8.png') }}" alt="Guide">
        <p class="sentence">It will display a notification that the SSS contribution table has been updated successfully.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/sss-9.png') }}" alt="Guide">
        <p class="sentence">To further check if the changes are integrated in the system, Scroll down to the Full Bracket Reference.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/philhealth-1.png') }}" alt="Guide">
        <p class="sentence">For editing PhilHealth, click <b>PhilHealth</b> to switch the tab.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/philhealth-2.png') }}" alt="Guide">
        <p class="sentence">To edit PhilHealth, input the effective date for system integration, the updated rate, and the updated salary floor and ceiling.</p>
        <br>        
        <img class="pic1" src="{{ asset('assets/tutorial/philhealth-3.png') }}" alt="Guide">
        <p class="sentence">Click <b>Save New Rate</b>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/philhealth-4.png') }}" alt="Guide">
        <p class="sentence">It will display a notification that the PhilHealth rate has been updated successfully.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/philhealth-5.png') }}" alt="Guide">
        <p class="sentence">It will also display the updated rate along with its status, which is Active. This means that the rate is currently being used by the system for the calculation processes involving PhilHealth deductions in the payroll.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/pagibig-1.png') }}" alt="Guide">
        <p class="sentence">For editing Pag-Ibig, click <b>Pag-Ibig</b> to switch the tab.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/pagibig-2.png') }}" alt="Guide">
        <p class="sentence">Click <b>Clone to Draft</b> to create a new policy involving Pag-Ibig deductions.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/pagibig-3.png') }}" alt="Guide">
        <p class="sentence">It will display a notification involving the cloned policy, which you will utilize to create the new policy.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/pagibig-4.png') }}" alt="Guide">
        <p class="sentence">Input the policy name of the new policy and the effective date for system integration. Set the status to <b>Active</b> so it will be automatically applied in the system. If there are changes, update the monthly fund salary cap and the rates for both employees and employers.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/pagibig-5.png') }}" alt="Guide">
        <p class="sentence">Click <b>Save Changes</b>.</p>
        <br>        
        <img class="pic1" src="{{ asset('assets/tutorial/pagibig-6.png') }}" alt="Guide">
        <p class="sentence">It will display a notification that the Pag-Ibig policy has been updated successfully.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/pagibig-7.png') }}" alt="Guide">
        <p class="sentence">It will also display the updated policy along with its status, which is Active. This means that this is currently being used by the system in the calculation of Pag-Ibig statutory deductions.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/pagibig-8.png') }}" alt="Guide">
        <p class="sentence">To further check if the created policy has been integrated in the system, you can use the simulator here.</p>
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
