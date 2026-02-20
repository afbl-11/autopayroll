@vite('resources/css/settings/settings.css')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<x-root>
    @include('layouts.employee-side-nav')
    <main class="main-content p-4">
        
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="fw-bold mb-1" style="color: var(--clr-primary);">Technical Guide</h2>
                    <p class="text-muted mb-0">Learn how to manage your account.</p>
                </div>
            </div>
                
    <div class="content">
        <div class="bar">
        <a href="{{ route('employee.tutorial.settings') }}" class="p">Settings Guide</a>
        <a href="{{ route('employee.tutorial.payslip') }}" class="s">Payslip Guide</a>
        <a href="{{ route('employee.tutorial.leave') }}" class="s">Leave Filing Guide</a>
        <a href="{{ route('employee.tutorial.credit') }}" class="s">Adjustment Filing Guide</a>
        </div>
        <p class="titles">Settings</p>
        <img class="pic1" src="{{ asset('assets/tutorial/emp-settings-1.png') }}" alt="Guide">
        <p class="sentence"><span class="k">T</span>he settings page allows the employee to edit their profile details in the system.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/emp-settings-3.png') }}" alt="Guide">
        <p class="sentence">To start, click that icon to navigate to the Settings page.</p>
        <br>        
        <img class="pic1" src="{{ asset('assets/tutorial/emp-settings-4.png') }}" alt="Guide">
        <p class="sentence">For changing your profile picture, click <b>Change Photo</b>, which will allow you to choose and upload your picture, and click <b>Save Changes</b>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/emp-settings-5.png') }}" alt="Guide">
        <p class="sentence">For changing your profile details, change the displayed information on the input and select dropdown fields, which are inputted during the registration of your account by the system admin, and click <b>Save Changes</b>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/emp-settings-6.png') }}" alt="Guide">
        <p class="sentence">For deleting your account, click <b>Delete Account</b> (However, this is strictly prohibited).</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/emp-settings-7.png') }}" alt="Guide">
        <p class="sentence">A modal will appear that will let you to enter your password first, before pressing <b>Confirm</b> to delete your account. </p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/emp-settings-8.png') }}" alt="Guide">
        <p class="sentence">For changing your password, click <b>Change Password</b>.</p>
        <br>
        <img class="pic1" src="{{ asset('assets/tutorial/emp-settings-9.png') }}" alt="Guide">
        <p class="sentence">You will be redirected to this page, where you must enter your current password before your new password. Then, re-enter the new password in the Confirm Password field to verify it before clicking <b>Confirm</b>.</p>
        <br>
    </div> 
        
    </main>
</x-root>
<style>
    .main-content {
        margin-left: var(--sidebar-width-collapsed);
        width: calc(100% - var(--sidebar-width-collapsed));
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        background: var(--clr-background);
        padding-bottom: 50px;
        transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1),
                    width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .main-content.main-content-expanded {
        margin-left: var(--sidebar-width-expanded);
        width: calc(100% - var(--sidebar-width-expanded));
    }
    
    .mb-4 {
        margin-left: 15px;
    }

.content {
    width: 100%;
    max-width: 1000px;   
    background: #fff;
    padding: 40px;
    margin: 40px auto;   
    border: 1px solid #e5e7eb;
    border-radius: 10px;
}

.bar {
    display: flex;
    justify-content: flex-end;
    gap: 15px;
    margin-bottom: 20px;
}

.titles {
    font-size: 20px;
    letter-spacing: 1.2px;
    border-bottom: 1px solid #e5e7eb;
    padding-bottom: 10px;
    margin-bottom: 30px;
}

.pic1,
.pic2 {
    width: 100%;          
    max-width: 850px;
    display: block;
    margin: 25px auto;
    border: 1px solid #e5e7eb;
    padding: 8px;
    border-radius: 8px;
}

.pic2 {
    max-width: 600px;
}

.sentence {
    text-align: justify;
    max-width: 800px;
    margin: 0 auto 20px auto;
}

.k {
    font-size: 28px;
}

.s, .p {
    padding: 2px;
    padding-left: 15px;
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
    padding-left: 0px;
}

@media (max-width: 1300px) {
    .pic1 {
        width: 600px;
    }
}

@media (max-width: 1100px) {
    .pic1 {
        width: 500px;
    }
    .content {
        margin-left: 10px;
    }
}

@media (max-width: 950px) {
    .pic1 {
        width: 100%;
    }    
}

@media (max-width: 700px) {
    .s, .p {
        font-size: 11px;
    }
    .bar {
        
        flex-direction: column;
        gap: 8px;
        align-items: center;
        margin-top: 10px;
        margin-bottom: 10px;
        border-bottom: 1px solid #e5e7eb;
        border-top: 1px solid #e5e7eb;
    }
    .bar a{
        text-align: center;
    }
    .s {
        border-left: 0px;
        padding-left: 0;
    }
    .p {
        padding-right: 2;
        padding-left: 0;
        margin-top: 20px;
    }
}
@media (max-width: 675px) {
    .mb-1 {
            font-size: 32px;
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
        width:95%;
    }
    .mb-1 {
        font-size: 30px;
    }
}
</style>

