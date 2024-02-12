        <form action="#" method="post">

            <center>
                <h2><b>Actualizar reportes</b></h2>
            </center>
            <div class="form-container" style="display: flex; flex-wrap: wrap; margin-top: 30px;">

                <div class="form">
                    <label for="titulo">
                        <p>Iniciales del titulo del rector/a</p>
                    </label>
                    <input class="input" type="Text" id="titulo" oninput="validarTexto(this)" name="titulo">
                    <span class="input-border"></span>
                </div>
                <div class="form">
                    <label for="nombre">
                        <p>Nombres y apellidos del rector/a</p>
                    </label>
                    <input class="input" type="Text" id="nombre" name="nombre">
                    <span class="input-border"></span>
                </div>


                <div class="form">
                    <label for="genero">
                        <p>Genero</p>
                    </label>
                    <select class="input" id="genero" name="genero">
                        <option value="" selected disabled>Seleccione un genero</option>
                        <option value="director">Masculino</option>
                        <option value="directora">Femenino</option>
                    </select> <span class="input-border"></span>
                </div>

                <div class="form">
                    <label for="correo">
                        <p>Correo institucional</p>
                    </label>
                    <input class="input" type="email" id="correo"" name=" correo"">
                    <span class="input-border"></span>
                </div>



                <div class="form">
                    <label for="celular">
                        <p>Celular de la institucion</p>
                    </label>
                    <input class="input" type="email" id="celular" name="celular">
                    <span class="input-border"></span>
                </div>
            </div>
            <div class="form-container" style="display: flex; flex-wrap: wrap; margin-top: 30px;">
                <button style="cursor: pointer; font-size: 20px; color:white; border-radius: 10px; background: #FF0000;" class="input" type="submit" name="btreporte">
                    Actualizar Reportes
                </button>
            </div>
        </form>