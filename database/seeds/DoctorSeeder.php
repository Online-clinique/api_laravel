<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;






class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {
        //

        for ($i = 0; $i < 50; $i++) {
            $current_id = Str::uuid();


            $ville = json_decode("[\"Autre\",\"Agadir\",\"Arfoud\",\"Azrou\",\"Benguérir\",\"Beni Mellal\",\"Benslimane\",\"Berkane\",\"Berrechid\",\"Casablanca\",\"Dakhla\",\"Dar Bouazza\",\"El Jadida\",\"Errachidia\",\"Essaouira\",\"Fkih Ben Saleh\",\"Fés\",\"Had Soualem\",\"Inezgane\",\"Khemisset\",\"Khouribga\",\"Khénifra\",\"Kénitra\",\"Larache\",\"Laâyoune\",\"Marrakech\",\"Mechra Bel Ksiri\",\"Meknés\",\"Mohammedia\",\"Nador\",\"Ouarzazate\",\"Oujda\",\"Rabat\",\"Safi\",\"Salé\",\"Settat\",\"Sidi Bennour\",\"Sidi Kacem\",\"Skhirat\",\"Tanger\",\"Taroudant\",\"Tata\",\"Taza\",\"Temara\",\"Tétouan\"]");
            $name = array_merge(
                json_decode(
                    "[\"Bahae Said\",\"Sulayma Benjelloun\",\"Zinah Serghini\",\"Sabreen al-Fassi\",\"Alzahra Lahbabi\",\"Shukriya ibn al-Hassan\",\"Fairouz Menebhi\",\"Anaan Bouzfour\",\"Mahdia Barakat\",\"Tahani Bahéchar\",\"Balqis Siqli\",\"Malika Elalamy\",\"Darifa Mansouri\",\"Tissam Bennouna\",\"Ayesha Sahimi\",\"Yasmina Benjelloun\",\"Aider El-Moustaoui\",\"Najiha al-Makki\",\"Ghaada El Hajjam\",\"Nyla al-Tayyeb\",\"Masuda Idrissi\",\"Kamar Lahbabi\",\"Khadija Laroui\",\"Mahdia Ben Bouchta\",\"Masuda Ferhat\",\"Rahida al-Ghumari\",\"Gadwa Zafzaf\",\"Aziza al-Buzidi\",\"Reema  Raihani\",\"Shenaz Nissaboury\"]"
                ),
                json_decode("[\"Abdelaziz Salem\",\"Zaubayr Bourkia\",\"Lahcen Abécassis\",\"Brahim Chaoui\",\"Sadid Akhrif\",\"Quds Said\",\"Hamza Yassine\",\"Farid Bennis\",\"Amaniyy Lemsih\",\"Zamen Benjelloun\",\"Asil Leghlid\",\"Waqqas Raihani\",\"Abdullah Rhozali\",\"Waliedine Mejjati\",\"Marzuq Hajji\",\"Hakem Mansouri\",\"Asil Barakat\",\"Waqqas Benchemsi\",\"Muwaffaq Lahbabi\",\"Youssouf Salem\",\"Elias Jouiti\",\"Mojiz Tawil\",\"Abdelilah Ben Bouchta\",\"Wasif Daoud\",\"Quds Skali\",\"Jamaldine Barbery\",\"Abdellatif Sahimi\",\"Hadir Lahlou\",\"Younes Toulali\",\"Farid Torres\"]")
            );
            $speciality = json_decode('["Medecin-generaliste","Ophtalmologue","Oto-Rhino-Laryngologiste-ORL","Dermatologue","Pediatre","Dentiste","Gynecologue","Gastrologue-Enterologue","Cardiologue","Chirurgien-General","Urologue","Traumatologue-Orthopediste","Anesthesiste-Reanimateur","Gynecologue-Obstetricien","Neuropsychiatre","Radiologue","Pneumo-Phtisiologue","Rhumatologue","Psychiatre","Neurochirurgien","Neurologue","Nephrologue","Biologiste","Interniste","Chirurgien-Dentiste","Endocrinologue-diabetologue-et-maladies-metaboliques","Medecin-du-travail","Allergologue","Anatomo-pathologiste","Diabetologue-nutritionniste","Chirurgien-esthetique-et-plastique","Cardio-Vasculaire","Chirurgien-Cardio-Vasculaire","Hematologue","Chirurgien-pediatrique","Stomatologue-et-chirurgien-maxillo-facial","Radiologue","Chirurgien-vasculaire-peripherique","Traumatologue","Chirurgien-thoracique","Medecin-du-Sport","Chirurgien-Maxillo-Facial","Kinesitherapeute","Cancerologue","Medecin-physique-et-readaptation-fonctionnelle","Oncologue-medical","Pedopsychiatre","Opticien","Medecin-Legale-et-du-Travail","Medecin-de-reeducation-readaptation-fonctionnelle","Addictologue","Radiologue-Radio-Isotopie","Immunologiste","Medecin-specialiste-des-maladies-infectieuses","Endodontiste","Orthodontiste","Chirurgien-cancerologue","Medecin-specialiste-en-Medecine-nucleaire","Greffe-osseuse","Psychotherapeute","Medecin-communautaire","Chirurgien-Infantile","Micronutrition","Acupuncture","Geriatre","Implantologist","Endocrinologue","Gastro-enterologue","Proctologue","Hollywood-smile","Coaching","Psychonutrition","Couronne-dentaire","Aroma-therapeute","Therapies","Prothese-dentaire","Esthetique-dentaire","Medecine-Esthetique","Lasers-Medicaux","Medecine-Regenerative"]');
            print_r($speciality);

            DB::table('medic')->insert([
                'id' => $current_id,
                'username' => Str::random(10) . '@gmail.com',
                'password' => Hash::make('password'),
                'added_by' => Str::lower('F8DDC1CA-B865-4C23-8208-059F3AA3B9A0'),
                "account_status" => "pending",
                'ville' => $ville[array_rand($ville, 1)],
                'full_name' => $name[array_rand($name, 1)]
            ]);

            DB::table('expertises')->insert([
                'id' => Str::uuid(),
                'slug' => $speciality[array_rand($speciality)],
                'medic_id' => $current_id
            ]);
        }
    }
}
