<?php

namespace Database\Seeders;

use App\Models\Faqs;
use Illuminate\Support\Str;

class FaqsSeeder extends BaseSeeder
{


    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Faqs::create([
            'id' => 1,
            'question' => 'What is the Mukhya Mantri Swavlamban Yojna?',
            'answer' => 'The Mukhya Mantri Swavlamban Yojna is a government-initiated scheme designed to promote entrepreneurship and self-employment among the youth and aspiring entrepreneurs in the state. It aims to provide financial support, training, and resources to help individuals establish and run their own businesses, ultimately fostering economic growth and job creation.',
            'status' => 'Active',
        ]);

        Faqs::create([
            'id' => 2,
            'question' => 'Who is eligible to apply for the Mukhya Mantri Swavlamban Yojna?',
            'answer' => 'Eligibility criteria for the Mukhya Mantri Swavlamban Yojna typically include factors such as age, residency, educational qualifications, income levels, and the submission of a detailed business proposal. While specific criteria may vary from state to state, the scheme generally targets individuals who are between 18 and 40 years old, residents of the respective state, possess a minimum level of education, and have a viable business idea.',
            'status' => 'Active',
        ]);

        Faqs::create([
            'id' => 3,
            'question' => 'What types of support are provided under this scheme?',
            'answer' => 'The Mukhya Mantri Swavlamban Yojna offers a range of support measures, including financial assistance in the form of loans or subsidies, skill development programs, and access to resources and mentorship. The specific benefits can vary, but the goal is to equip aspiring entrepreneurs with the necessary tools and resources to establish and sustain their businesses.',
            'status' => 'Active',
        ]);

        Faqs::create([
            'id' => 4,
            'question' => 'How can I apply for the Mukhya Mantri Swavlamban Yojna?',
            'answer' => 'To apply for the scheme, interested individuals should check the official website of their state government or contact the relevant government authorities to obtain detailed information about the application process. Typically, applicants need to submit their business proposals, meet the eligibility criteria, and follow the application instructions provided by the government.',
            'status' => 'Active',
        ]);
    }
}
