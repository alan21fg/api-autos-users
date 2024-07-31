<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Autos>
 */
class AutosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Definir listas de modelos por marca
        $modelosPorMarca = [
            'Abarth' => ['Abarth 595', 'Abarth 124 Spider', 'Abarth 695 Competizione'],
            'Alfa Romeo' => ['Alfa Romeo Giulia', 'Alfa Romeo Stelvio', 'Alfa Romeo 4C'],
            'Aston Martin' => ['Aston Martin DB11', 'Aston Martin Vantage', 'Aston Martin DBS Superleggera'],
            'Audi' => ['Audi A3', 'Audi A4', 'Audi Q7'],
            'Bentley' => ['Bentley Continental GT', 'Bentley Bentayga', 'Bentley Flying Spur'],
            'BMW' => ['BMW 3 Series', 'BMW X5', 'BMW M4'],
            'Cadillac' => ['Cadillac CTS', 'Cadillac Escalade', 'Cadillac XT5'],
            'Caterham' => ['Caterham Seven 270', 'Caterham Seven 420R', 'Caterham Seven 620R'],
            'Chevrolet' => ['Chevrolet Camaro', 'Chevrolet Corvette', 'Chevrolet Silverado'],
            'Citroën' => ['Citroën C3', 'Citroën C4', 'Citroën C5 Aircross'],
            'Dacia' => ['Dacia Duster', 'Dacia Sandero', 'Dacia Logan'],
            'Ferrari' => ['Ferrari 488 GTB', 'Ferrari F8 Tributo', 'Ferrari LaFerrari'],
            'Fiat' => ['Fiat 500', 'Fiat Panda', 'Fiat Tipo'],
            'Ford' => ['Ford Mustang', 'Ford F-150', 'Ford Focus'],
            'Honda' => ['Honda Civic', 'Honda Accord', 'Honda CR-V'],
            'Infiniti' => ['Infiniti Q50', 'Infiniti QX60', 'Infiniti QX80'],
            'Isuzu' => ['Isuzu D-Max', 'Isuzu MU-X', 'Isuzu Trooper'],
            'Iveco' => ['Iveco Daily', 'Iveco Eurocargo', 'Iveco Stralis'],
            'Jaguar' => ['Jaguar F-Type', 'Jaguar XE', 'Jaguar XJ'],
            'Jeep' => ['Jeep Wrangler', 'Jeep Grand Cherokee', 'Jeep Compass'],
            'Kia' => ['Kia Sportage', 'Kia Seltos', 'Kia Stinger'],
            'KTM' => ['KTM X-Bow', 'KTM RC 390', 'KTM Duke 890'],
            'Lada' => ['Lada Niva', 'Lada Vesta', 'Lada Granta'],
            'Lamborghini' => ['Lamborghini Huracán', 'Lamborghini Aventador', 'Lamborghini Urus'],
            'Lancia' => ['Lancia Delta', 'Lancia Ypsilon', 'Lancia Thema'],
            'Land Rover' => ['Land Rover Defender', 'Land Rover Discovery', 'Land Rover Range Rover'],
            'Lexus' => ['Lexus RX', 'Lexus ES', 'Lexus LC'],
            'Lotus' => ['Lotus Elise', 'Lotus Evora', 'Lotus Exige'],
            'Maserati' => ['Maserati Ghibli', 'Maserati Levante', 'Maserati Quattroporte'],
            'Mazda' => ['Mazda MX-5', 'Mazda CX-5', 'Mazda3'],
            'Mercedes-Benz' => ['Mercedes-Benz E-Class', 'Mercedes-Benz GLE', 'Mercedes-Benz S-Class'],
            'Mini' => ['Mini Cooper', 'Mini Countryman', 'Mini Clubman'],
            'Mitsubishi' => ['Mitsubishi Outlander', 'Mitsubishi Lancer', 'Mitsubishi Pajero'],
            'Morgan' => ['Morgan Plus 4', 'Morgan 3-Wheeler', 'Morgan Aero 8'],
            'Nissan' => ['Nissan Altima', 'Nissan Rogue', 'Nissan GT-R'],
            'Opel' => ['Opel Astra', 'Opel Insignia', 'Opel Grandland'],
            'Peugeot' => ['Peugeot 208', 'Peugeot 3008', 'Peugeot 508'],
            'Piaggio' => ['Piaggio Vespa', 'Piaggio MP3', 'Piaggio Liberty'],
            'Porsche' => ['Porsche 911', 'Porsche Cayenne', 'Porsche Macan'],
            'Renault' => ['Renault Clio', 'Renault Captur', 'Renault Megane'],
            'Rolls-Royce' => ['Rolls-Royce Phantom', 'Rolls-Royce Cullinan', 'Rolls-Royce Ghost'],
            'Seat' => ['Seat Ibiza', 'Seat Leon', 'Seat Ateca'],
            'Skoda' => ['Skoda Octavia', 'Skoda Kodiaq', 'Skoda Superb'],
            'Smart' => ['Smart EQ ForTwo', 'Smart EQ ForFour', 'Smart Roadster'],
            'SsangYong' => ['SsangYong Rexton', 'SsangYong Tivoli', 'SsangYong Korando'],
            'Subaru' => ['Subaru Impreza', 'Subaru Outback', 'Subaru Forester'],
            'Suzuki' => ['Suzuki Swift', 'Suzuki Vitara', 'Suzuki Jimny'],
            'Tata' => ['Tata Nexon', 'Tata Harrier', 'Tata Tiago'],
            'Tesla' => ['Tesla Model S', 'Tesla Model 3', 'Tesla Model X'],
            'Toyota' => ['Toyota Camry', 'Toyota RAV4', 'Toyota Corolla'],
            'Volkswagen' => ['Volkswagen Golf', 'Volkswagen Passat', 'Volkswagen Tiguan'],
            'Volvo' => ['Volvo XC90', 'Volvo S60', 'Volvo V60']
        ];

        // Seleccionar una marca aleatoria
        $marca = $this->faker->randomElement(array_keys($modelosPorMarca));

        // Seleccionar un modelo basado en la marca elegida
        $modelo = $this->faker->randomElement($modelosPorMarca[$marca]);

        // Generar un año aleatorio entre 1990 y 2024
        $año = $this->faker->numberBetween(1990, 2024);

        $descripcion = $this->faker->randomElement([
            'Este auto compacto combina un diseño elegante con un manejo ágil y eficiente. Ideal para la ciudad, ofrece una excelente economía de combustible y una cabina sorprendentemente espaciosa para su tamaño.',
            'Con un diseño robusto y una altura elevada, este SUV proporciona comodidad y espacio para toda la familia. Sus capacidades todoterreno y la tracción integral garantizan un rendimiento confiable en diversas condiciones de carretera.',
            'Este auto deportivo destaca por su diseño aerodinámico y su potente motor. Ofrece una experiencia de conducción emocionante con una aceleración rápida y una suspensión deportiva que asegura un manejo preciso y dinámico.',
            'Con una cabina lujosa y acabados de alta calidad, este sedán ofrece un viaje cómodo y refinado. Sus características avanzadas de tecnología y seguridad hacen que cada viaje sea una experiencia placentera y segura.',
            'Este hatchback combina funcionalidad con estilo, ofreciendo un maletero espacioso y un diseño compacto. Ideal para quienes buscan un auto versátil para el uso diario, con un rendimiento eficiente y facilidad de estacionamiento.'
        ]);

        $imageUrl = $this->faker->randomElement([
            'https://www.fiateastrand.co.za/images/Vehicles/Abarth/595/2024/Abarth-595-gallery-dk-526x380_1.jpg',
            'https://www.alfaromeo.mx/content/dam/alfa/cross/tonale-plug-in-hybrid/trim/trim-image/AR-Home-Trim-Tonale-PHEV-Ti.png',
            'https://cdn.autobild.es/sites/navi.axelspringer.es/public/bdc/dc/fotos/Aston_Martin-DB11_2017_C01.jpg?tf=3840x',
            'https://acroadtrip.blob.core.windows.net/catalogo-imagenes/m/RT_V_a9ff7b9209d8459a8555b9d0d1a40ddf.jpg',
            'https://autosdeprimera.com/wp-content/uploads/2024/05/bentley-batur-convertible-2024-frente.jpg',
            'https://www.bmw.com.mx/content/dam/bmw/common/all-models/m-series/m8-coupe/2022/onepager/bmw-m8-coupe-onepager-sp-desktop.jpg',
            'https://www.elcarrocolombiano.com/wp-content/uploads/2023/05/22-05-2023-PORTADA-Avatr-11-1.jpg',
            'https://caterhamcars.com/templates/yootheme/cache/15/1-620R-f3q-15a605cd.jpeg',
            'https://www.chevrolet.com.mx/content/dam/chevrolet/na/mx/es/index/cars/01-images/2023/2024-aveo-hb.jpg?imwidth=960',
            'https://cdn.autobild.es/sites/navi.axelspringer.es/public/bdc/dc/fotos/C4_2020.jpg?tf=3840x',
            'https://s3-eu-west-1.amazonaws.com/carnovo-images/review-models/066aac06-ff16-42ca-b5dd-35dd503a5808.jpg',
            'https://cdn.ferrari.com/cms/network/media/img/resize/5ddb97392cdb32285a799dfa-laferrari-2013-share?width=1080',
            'https://img.remediosdigitales.com/46b89d/fiat-500s-2017-1600-07/840_560.jpg',
            'https://acnews.blob.core.windows.net/imgnews/paragraph/NPAZ_2c02ce67e7fb44d99d23fc7475d64b30.jpg',
            'https://hondatec.com.mx/Assets/img/GarantiaExtendida/vehiculo-slider-desktop.png',
            'https://wieck-infiniti-production.s3.amazonaws.com/photos/07b373799698a435e13ec792b11b18bcb76b8001/preview-928x522.jpg',
            'https://www.isuzu.es/sites/isuzu.es/files/Crew_N60BB_landing_page.webp',
            'https://revistamagazzine.com/wp-content/uploads/2023/07/IVECO-VEHICULOS-PESADOS-ELECTRICOS-MAGAZZINE-DEL-TRANSPORTE-P.jpg',
            'https://img.remediosdigitales.com/da5f1f/jaguar-f-type-2021-precio-mexico_4/1366_2000.jpg',
            'https://cdn.forbes.com.mx/2024/03/Jeep-Wrangler-392-V8.jpg',
            'https://www.kia.com/content/dam/kwcms/kme/uk/en/assets/static/nav22/Explore_range/kia-xceed_2019-gt-line-s-spirit-green_512x288_left.png',
            'https://www.km77.com/images/medium/2/5/9/1/ktm-x-bow-gt-xr-2023-frontal-lateral.362591.jpg',
            'https://acnews.blob.core.windows.net/imgnews/paragraph/NPAZ_cbad74acb2864bbea0958796f5341fe6.jpg',
            'https://cdn.motor1.com/images/mgl/zxQBp4/s3/2024-lamborghini-revuelto-exterior.jpg',
            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQD9d362xEHoOxazD9t8epp1MWUBlB_597J7w&s',
            'https://jlr.scene7.com/is/image/jlr/L460_22MY_195_GLHD_AUTOBIOGRAPHY_SWB_DX',
            'https://media.es.wired.com/photos/64f25753c71adbd96335d9e1/16:9/w_2560%2Cc_limit/Lexus-LC500h-1-scaled.jpeg',
            'https://acnews.blob.core.windows.net/imgnews/medium/NAZ_da22c444c353442e974d4ecab1de8556.jpg',
            'https://maserati.scene7.com/is/image/maserati/maserati/international/Models/default/2023/mc20sr/versions/mc20-cielo.jpg?$600x2000$&fit=constrain',
            'https://www.mazda.mx/siteassets/mazda-mx/mycos-2024/mazda3-sedan/vlp/tarjetas-de-versiones/mazda-mexico-mazda3-sedan-vlp-versiones-i-sport-v1.png',
            'https://cdn.motor1.com/images/mgl/z6RkW/s1/en-el-garage-de-autoblog-mercedes-benz-a-250-sedan-amg-line.jpg',
            'https://acroadtrip.blob.core.windows.net/catalogo-imagenes/s/RT_V_93e011d314954ad39d7b2ae479b6a53f.jpg',
            'https://acroadtrip.blob.core.windows.net/catalogo-imagenes/s/RT_V_1c63e34e6de24e4abbca9f516207c532.jpg',
            'https://e00-marca.uecdn.es/assets/multimedia/imagenes/2024/05/16/17158564262307.jpg',
            'https://acroadtrip.blob.core.windows.net/catalogo-imagenes/m/RT_V_4b4578b2047947618873ae0665be3a54.webp',
            'https://img.remediosdigitales.com/95abfa/opel-astra-2022_/500_333.jpeg',
            'https://img.remediosdigitales.com/196a11/peugeot-e-208-2024-1600-01/840_560.jpeg',
            'https://acroadtrip.blob.core.windows.net/catalogo-imagenes/s/RT_V_5300b68ac1794bf99e4ac8e4946264b4.webp',
            'https://acroadtrip.blob.core.windows.net/catalogo-imagenes/s/RT_V_014c8d25467147e1b60efe3a92f81481.jpg',
            'https://media.gq.com.mx/photos/641f391cf8c983a1859faa20/16:9/w_2560%2Cc_limit/P90498647_highRes_rolls-royce-black-ba%2520(1).jpg',
            'https://www.seat.mx/content/dam/countries/mx/seat-website/models/nuevo-ibiza/specs/versions/seat-ibiza-style-2022-vista-frontal.png',
            'https://cdn.drivek.com/configurator-imgs/cars/es/Original/SKODA/KAMIQ/43247_SUV-5-DOORS/skoda-kamiq-front-view.jpg',
            'https://www.km77.com/images/medium/4/9/8/7/mediana-ext-1.344987.jpg',
            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSYCN8nyQk4KCmFz8BAxvgA0L07DHk8_lKsJw&s',
            'https://cdn.motor1.com/images/mgl/qjvEq/s3/2020-subaru-wrx-sti-render.jpg',
            'https://suzukisantaclara.com/assets-gral/carousel-home/swift-bosterjet-sport/swift-sport.png?1232132323232',
            'https://imgd-ct.aeplcdn.com/664x415/n/cw/ec/141873/nexon-facelift-right-front-three-quarter-2.jpeg?isig=0&q=80',
            'https://www.eleconomista.com.mx/__export/1574439240187/sites/eleconomista/img/2019/11/22/tesla-01.jpg_1758632412.jpg',
            'https://acroadtrip.blob.core.windows.net/catalogo-imagenes/m/RT_V_0103188470034d88a7b69fb3430a5a88.jpg',
            'https://cdn.motor1.com/images/mgl/YA7nqr/s1/vw-taos-frente.jpg',
            'https://cloudfront-eu-central-1.images.arcpublishing.com/diarioas/I7PBLLKP2NASFLG2E66CRA5SHQ.jpg'
        ]);

        return [
            'marca' => $marca,
            'modelo' => $modelo,
            'año' => $año,
            'color' => $this->faker->safeColorName,
            'matricula' => $this->faker->bothify('??-###'),
            'precio' => $this->faker->randomFloat(2, 100000, 2000000),
            'estado' => $this->faker->randomElement(['nuevo', 'seminuevo', 'usado']),
            'descripcion' => $descripcion,
            'imagen' => $imageUrl,
        ];


    }
}
