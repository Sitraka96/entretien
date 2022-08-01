<div id="feedback" class="fixed-top m-2"></div>
<div class="d-flex justify-content-center mt-5">
    <form action="" method="POST" id="login" class="col-11 col-md-8 col-lg-3 p-4 rounded shadow">
        <p class="mt-4 text-center">
            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px" viewBox="0 0 510 510" style="enable-background:new 0 0 510 510;" xml:space="preserve">
                <path class="user-img" d="M437.02,330.98c-27.883-27.882-61.071-48.523-97.281-61.018C378.521,243.251,404,198.548,404,148
            C404,66.393,337.607,0,256,0S108,66.393,108,148c0,50.548,25.479,95.251,64.262,121.962
            c-36.21,12.495-69.398,33.136-97.281,61.018C26.629,379.333,0,443.62,0,512h40c0-119.103,96.897-216,216-216s216,96.897,216,216
            h40C512,443.62,485.371,379.333,437.02,330.98z M256,256c-59.551,0-108-48.448-108-108S196.449,40,256,40
            c59.551,0,108,48.448,108,108S315.551,256,256,256z" />
            </svg>
        </p>
        <p class="h5 text-center mb-4">Se connecter</p>

        <label for="username">Nom d'utilisateur</label>

        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text bg-white text-primary">
                    <svg>
                        <use xlink:href="/assets/svg/inc.svg#username">
                    </svg>
                </span>
            </div>
            <input type="text" name="username" class="form-control" id="username" placeholder="Nom d'utilisateur" required>
        </div>
        <label for="pwd">Mot de passe</label>
        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text bg-white text-primary">
                    <svg>
                        <use xlink:href="/assets/svg/inc.svg#lock">
                    </svg>
                </span>
            </div>
            <input type="password" name="password" class="form-control" id="pwd" placeholder="Mot de passe" required>
        </div>
        <div class="d-flex justify-content-end martop">
            <a href="#">Mot de passe oublié ?</a>
        </div>
        <div class="d-flex justify-content-center mt-3">
            <button type="submit" id="submit-btn" class="btn btn-outline-primary px-4">se connecter</button>
        </div>
    </form>
</div>