<!-- Echo 1 -->
<div class="establishment_services">

<div class="service">
    <div class="service_info">
        <h3>Nome do serviço</h3>
        <p>Descrição do serviço</p>
    </div>
    
    <form action="" method="POST">
        
        <div class="next_week">
            <!-- Echo 2 -->
            <div class="form_input">
                <input type="radio" name="available_day" class="available_day_1" id="week_day_1" value="1" checked>
                <label for="week_day_1" class="service_button">dd/mm</label>
            </div>
            <!-- PRINTAR PROXIMOS 7 DIAS -->
            <!-- Echo 3 -->
        </div>

        <div class="days_slider" id="days_slider_1">

            <!-- Echo 4 -->
            <div class="available_times slide">
                <!-- Echo 5 -->
                <div class="form_input">
                    <input type="radio" name="available_times" id="times_1" value="1">
                    <label for="times_1" class="service_button">19:00</label>
                </div>
                <!-- PRINTAR PARA CADA DIA UM SLIDE E PARA CADA SLIDE TODOS OS HORÁRIOS -->
                <!-- Echo 6 -->
            </div>
            
        <!-- Echo 7 -->
        </div>
        
        <div class="green_button submit_button">
            <button type="submit" name="service_id" value="1">Agendar</button>
        </div>
    </form>
</div>