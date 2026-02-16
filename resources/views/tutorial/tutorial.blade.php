
<x-app title="Guide">

    <div class="links">
        <ul>
            <li><a class="a" href="">Admin Dashboard & Settings</a></li>
            <li><a class="v"href="">Attendance</a></li>
            <li><a class="v"href="">Leave & Credit Management</a></li>
            <li><a class="v"href="">Employee and Client Management</a></li>
            <li><a class="v" href="">Salary & Tax Management</a></li>
        </ul>
    </div>

    <div class="content">
        <p class="titles">Dashboard</p>
        <img class="pic1" src="{{ asset('assets/tutorial/admin-dashboard_upper-2.png') }}" alt="Guide">
        <p class="sentence"><span class="k">T</span>he dashboard page presents the summary of the overall operations of the registered company, including the total number of employees, overall payroll costs, and manpower distribution.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/requests.png') }}" alt="Guide">
        <p class="sentences">In addition, it also displays the pending requests submitted by employees.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/highlighted-requests.png') }}" alt="Guide">
        <p class="sentences">These requests are clickable, which can redirect the user to the details of those specificied requests for approval.</p>
        <br>
        <a href="{{ route('tutorial.settings') }}" class="s">Next Page</a>
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
}
.sentences {
    text-align: center;
    margin-bottom: 15px;
}
.s {
    padding: 12px;
    background-color: #FFD858;
    letter-spacing: 1.33px;
    color: black;
    border-radius: 16px;
    text-decoration: none;
    display: block;
    margin: 40px auto 0 auto;
     width: fit-content;
}
.s:hover {
    transition: 0.3s ease-out;
    background-color: black;
    color: #FFD858;
}
</style>
