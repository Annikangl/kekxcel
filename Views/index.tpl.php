<?php
// echo "<pre>";
// print_r($pageData);
// echo "</pre>";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <header class="header">
        <nav class=" teal">
            <div class="container">
                <div class="nav-wrapper">
                    <a href="#" class="brand-logo">Excel import/export</a>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                        <li><a href="sass.html">Title</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="main" style="margin-top: 80px;">
        <section class="form">
            <div class="container">
                <div class="row">
                    <div class="message__area" style="display: none;">
                        <div class="card-panel red lighten-4"></div>
                    </div>
                    <form method="POST" id="import_excel_form" enctype="multipart/form-data">
                        <div class="file-field input-field col s6">
                            <div class="btn">
                                <span>Выбрать файл</span>
                                <input type="file" name="import_excel" multiple>
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" placeholder="Загрузить .xls, .xlsx">
                            </div>
                        </div>
                        </br>

                        <button class="btn waves-effect waves-light" type="submit" name="import" id="import">Импорт</button>
                    </form>

                    <form name="export" method="POST">
                        <button class="btn waves-effect waves-light" type="submit" name="export" id="import">Экспорт</button>
                    </form>
                </div>
            </div>
        </section>


        <section class="table-sec">
            <div class="table-container">
                <div id="excel_area">
                    <table class="centered" border="1">
                        <thead>
                            <tr>
                                <th rowspan="2">№ п/п</th>
                                <th rowspan="2">ID</th>
                                <th rowspan="2">Фамилия</th>
                                <th rowspan="2">Имя</th>
                                <th rowspan="2">Отчество</th>
                                <th rowspan="2">Дата рождения</th>
                                <th rowspan="2">Место рождения</th>
                                <th rowspan="2">Адрес регистрации</th>
                                <th rowspan="2">Дата обращения</th>
                                <th colspan="5">Документ гражданской принадлежности</th>
                                <th rowspan="2">Номер мобильного телефона</th>
                                <th rowspan="2">Место работы</th>
                                <th rowspan="2">Примечание</th>
                            </tr>
                            <tr>
                                <th>Вид документа</th>
                                <th>Серия</th>
                                <th>Номер</th>
                                <th>Дата выдачи</th>
                                <th>Кем выдан</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>11</td>
                                <td>1421048448261517</td>
                                <td>Иванов</td>
                                <td>Иван</td>
                                <td>Федорович</td>
                                <td>Федорович</td>
                                <td>Федорович</td>
                                <td>Федорович</td>
                                <td>11/01/10</td>
                                <td>Паспорт</td>
                                <td>0099</td>
                                <td>99999933</td>
                                <td>12.05.2020</td>
                                <td>МВД ДНР</td>
                                <td>071 000 00 00</td>
                                <td>IT</td>
                                <td>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Officia dignissimos dolorem autem architecto facilis rem distinctio odio officiis vel, nesciunt debitis! Consectetur, eligendi. Ad odio eos accusamus, nemo, ipsum odit autem reprehenderit dolore facilis, minus tenetur ab consequuntur! Ea, quis inventore magni quos velit aliquid vel minima quasi doloremque ipsum?</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        $('#import_excel_form').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: "import",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                dataType: 'text',
                cache: false,
                processData: false,

                beforeSend: function() {

                },

                success: function(data) {
                    console.log(data);
                    // location.reload();
                },

                complete: function(msg) {
                    console.log(msg);
                }

            })
        })
    })
</script>

</html>