<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>MAIL</title>

        <!-- Estilos -->
        <link href="http://fonts.cdnfonts.com/css/ethnocentric" rel="stylesheet">

    </head>
    <body>
        <table style="max-width: 600px; padding: 10px; margin:0 auto; border-collapse: collapse;">

            <tr>
                <td style="padding: 0">
                    <img style="padding: 0; display: block" src="https://i.ibb.co/RHPr5gz/BANNER-GG-YOUTUBE.png" width="100%">
                </td>
            </tr>

            <tr>
                <td style="background-color: #ecf0f1">
                    <div style="color: #34495e; margin: 4% 10% 2%; text-align: justify;font-family: sans-serif">
                        <h2 style="color:linear-gradient(180deg, rgba(0,0,0,1) 0%, rgba(41,0,42,1) 50%, rgba(0,38,38,1) 100%); margin: 0 0 7px">Hola Glitch Gaming!</h2>
                        <p style="margin: 2px; font-size: 15px">Les comunicamos que <b>{{$nombre??'Glitch Gaming'}}</b>, tiene una consulta para vosotros! Veamos que es.</p>
                        <br>
                        <p style="margin: 2px; font-size: 15px">Asunto:&nbsp;<b>{{$subject??'Asunto'}}</b></p>
                        <br>
                        <p style="margin: 2px; font-size: 15px">
                            Mensaje:&nbsp;<b>{{$mensaje??'Mensaje'}}</b>
                        </p>
                        
                        <br>
                        
                        <p style="margin: 2px; font-size: 15px">
                            Este el correo electrónico de <b>{{$nombre??'Glitch Gaming'}}</b>:&nbsp;<b>{{$de??'info@glitchgaming.es'}}</b>
                        </p>
                    
                        <p style="color: #b3b3b3; font-size: 12px; text-align: center;margin: 30px 0 0">GlitchGaming ©</p>
                    </div>
                </td>
            </tr>
        </table>
    </body>
</html>