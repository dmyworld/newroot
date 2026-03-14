<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marketplace_migration_p8_categories extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('aauth');
        if (!$this->aauth->is_loggedin()) {
            exit('Please login to continue');
        }
        $this->load->dbforge();
    }

    public function index() {
        $data = [
            'TOURISM & TRAVEL INDUSTRY' => [
                'Tours & Experiences' => [
                    'Guided City & Cultural Tours (Colombo, Kandy, Galle Fort)',
                    'Wildlife Safaris (Yala, Wilpattu, Udawalawe, Minneriya)',
                    'Adventure & Eco-Tourism (Hiking, Trekking, Mountain Biking, Hot Air Ballooning, White Water Rafting)',
                    'Pilgrimage & Religious Tours (Adam' . "'" . 's Peak, Temple of the Tooth, Ancient Temples, Kovils)',
                    'Tea Estate Tours & Tasting Experiences',
                    'Sri Lankan Cooking Classes & Spice Garden Tours',
                    'Whale & Dolphin Watching Tours (Mirissa, Kalpitiya)',
                    'Scuba Diving, Snorkeling & Surfing Instructors',
                    'Bird Watching Tours (Kumana, Sinharaja Rain Forest)',
                    'Photography & Videography Tours',
                    'Village Life & Agro-Tourism Experiences',
                    'Customized Luxury Tour Concierge'
                ],
                'Travel & Logistics' => [
                    'Private Driver & Chauffeur Services (Daily/Hourly)',
                    'Airport & Hotel Transfer Services',
                    'Three-Wheeler (Tuk-Tuk) Rental with Driver',
                    'Multilingual Tour Guide Services (English, Chinese, Russian, etc.)',
                    'Custom Travel Itinerary Planning & Booking Agent',
                    'Visa & Travel Documentation Assistance',
                    'Tourist SIM Card & Connectivity Setup Services'
                ],
                'Accommodation & Stays' => [
                    'Homestay & Guesthouse Management Services',
                    'Vacation Rental Management (Check-in, Cleaning, Maintenance)',
                    'Hotel & Resort Booking Agent Services'
                ]
            ],
            'CONSTRUCTION INDUSTRY' => [
                'Building & Construction' => [
                    'Architectural Design & 3D Rendering Services',
                    'Civil & Structural Engineering Consultancy',
                    'Quantity Surveyor & Cost Estimation',
                    'Masonry, Bricklaying & Blockwork',
                    'Formwork & Shuttering Carpentry',
                    'Reinforced Steel Work (Fabrication & Fixing)',
                    'Concrete Pouring & Supply',
                    'Site Supervision & Project Management',
                    'Land Surveying & Soil Testing'
                ],
                'Specialized Installation & Finishing' => [
                    'Tiling, Marble & Granite Work',
                    'Flooring (Wooden, Laminate, Vinyl) Installation',
                    'Interior & Exterior Painting & Wallpapering',
                    'Plumbing, Sanitaryware & Water Pump Installation',
                    'Electrical Wiring, DB Setup & Smart Home Installation',
                    'Aluminum, UPVC & Wooden Door/Window Installation',
                    'False Ceiling & Partition Wall Installation',
                    'Kitchen & Wardrobe Carpentry',
                    'Roofing (Tiles, Sheets, Waterproofing)',
                    'Elevator & Lift Installation Services',
                    'Solar Panel System Installation'
                ],
                'Heavy Equipment & Machinery' => [
                    'Backhoe/Loader & Excavator Hire with Operator',
                    'Concrete Mixer & Pump Truck Hire',
                    'Crane & Boom Lift Hire',
                    'Roller & Compactor Hire',
                    'Tipper Lorry & Dump Truck Hire'
                ]
            ],
            'LIFESTYLE INDUSTRY' => [
                'Home & Domestic Services' => [
                    'Deep, Spring & Post-Construction Cleaning',
                    'Pest Control (Rodents, Insects, Mosquitoes)',
                    'Gardening, Landscape Design & Maintenance',
                    'Full-Service Packing, Moving & Relocation',
                    'Solar Panel Installation & Maintenance',
                    'Swimming Pool Cleaning & Maintenance',
                    'Water Tank Cleaning & Purification',
                    'Appliance Repair & Maintenance (AC, Washing Machine, Refrigerator)',
                    'Locksmith & Security System Services',
                    'Home Organizer & Decluttering Specialist'
                ],
                'Personal Care & Wellness' => [
                    'At-Home Beauty Parlor (Facials, Waxing, Manicure/Pedicure)',
                    'At-Home Barber & Grooming Services',
                    'Therapeutic, Ayurveda & Sports Massage',
                    'Personal Fitness Trainer & Yoga/Pilates Instructor',
                    'Dietitian & Personalized Meal Planning',
                    'Marriage Proposal & Romantic Event Planning',
                    'Makeup Artist & Hairstylist for Events',
                    'Mehendi (Henna) Artist'
                ],
                'Events & Celebrations' => [
                    'Full-Service Event Planning & Coordination',
                    'Wedding Photographer & Videographer',
                    'Catering & Food Stall Services',
                    'Sound, Lighting & DJ Services',
                    'Event Decorator & Florist',
                    'MC (Master of Ceremonies) & Entertainer Booking',
                    'Venue Booking Agent',
                    'Wedding Cake Designer & Baker'
                ]
            ],
            'AUTOMOBILE INDUSTRY' => [
                'Vehicle Repair & Maintenance' => [
                    'General Car/Motorcycle/Three-Wheeler Service',
                    'Engine Rebuilding & Transmission Repair',
                    'Car Electrician & Auto Computer Diagnostics',
                    'Tire Sales, Fitting & Wheel Alignment/Balancing',
                    'Battery Inspection, Sales & Replacement',
                    'Regular Maintenance & Oil Change Services'
                ],
                'Specialized Automotive Services' => [
                    'Car AC Service, Repair & Regas',
                    'Denting, Painting & Full Body Repair',
                    'Interior & Exterior Car Detailing, Polishing',
                    'Car Upholstery Repair & Cleaning',
                    'On-Demand Fuel (Petrol/Diesel) Delivery',
                    'On-Demand Towing & 24/7 Roadside Assistance',
                    'Vehicle Inspection & Pre-Purchase Evaluation',
                    'Auto Glass & Windshield Replacement',
                    'Car Audio & Accessory Installation',
                    'CNG Kit Installation & Service',
                    'Hybrid & EV Battery Specialist'
                ]
            ],
            'MEDICAL & HOSPITAL INDUSTRY' => [
                'Paramedical & Home Care' => [
                    'At-Home Nursing Care & Injection Services',
                    'Physiotherapy & Post-Operative Rehabilitation',
                    'Elderly Care & Palliative Caregiver Services',
                    'Baby & New Mother Care (Postnatal Care)',
                    'Medical Equipment Rental (Beds, Wheelchairs, Oxygen Concentrators)',
                    'Disability Support & Care Services',
                    'Medical At-Home Lab Tests (Blood, Sugar, ECG)'
                ],
                'Diagnostic & Wellness' => [
                    'At-Home Blood & Lab Sample Collection',
                    'Ambulance & Patient Transport Services',
                    'Dietitian, Diabetes & Nutritional Counseling',
                    'Psychological Counseling & Therapy Sessions',
                    'Ayurvedic Doctor Consultation & Treatments',
                    'Dental Check-ups & Cleaning at Home (Mobile Clinics)',
                    'Optical & Eye-Testing at Home',
                    'Pharmacy & Medicine Delivery'
                ],
                'Hospital Support Services' => [
                    'Medical Facility Deep Cleaning & Sanitization',
                    'Medical Equipment Maintenance & Calibration',
                    'Hospital Laundry & Waste Management Services',
                    'Hospital IT & Software Support'
                ]
            ],
            'TECH & IT INDUSTRY' => [
                'IT Support & Repair' => [
                    'Computer & Laptop Repair & Upgrade',
                    'Printer, Scanner & Peripheral Setup/Repair',
                    'Home/Office Network, Wi-Fi & Server Setup',
                    'Data Recovery & Backup Solutions',
                    'Smartphone & Tablet Repair',
                    'IP Telephone & PBX System Installation'
                ],
                'Software & Digital Services' => [
                    'Custom Software, Mobile App & Web Development',
                    'Graphic Design, Video Editing & Animation',
                    'Digital Marketing, SEO & Social Media Management',
                    'CCTV, Alarm & Security System Installation',
                    'IT Security Audit & Cybersecurity Services',
                    'E-commerce Website Development & Management',
                    'Domain & Web Hosting Support',
                    'Data Analytics & Business Intelligence Services',
                    'Cloud Computing & Migration Consultant'
                ]
            ],
            'MUSIC INDUSTRY' => [
                'Music Education' => [
                    'Vocal & Singing Coach (Western & Eastern)',
                    'Instrument Tutors (Guitar, Piano, Drums, Violin, Sitar, Tabla)',
                    'Music Theory, Composition & Exam Preparation',
                    'Online Music Lessons & Tutorials'
                ],
                'Production & Performance' => [
                    'Session Musician for Weddings & Events',
                    'Sound Recording & Studio Engineer Services',
                    'Live Sound & Audio Technician for Events',
                    'Music Band & DJ Booking Agent',
                    'Instrument Tuning & Repair Services',
                    'Music Video Production & Direction',
                    'Songwriting & Jingle Composition Services'
                ]
            ],
            'BUSINESS & PROFESSIONAL INDUSTRY' => [
                'Professional Services' => [
                    'Legal Consultant & Lawyer (Corporate, Property, Family)',
                    'Chartered Accountant, Auditor & Tax Consultant',
                    'Business & Startup Consultant',
                    'HR Consultant, Recruitment & Payroll Services',
                    'Marketing & Branding Consultant',
                    'Management Consultant & Corporate Trainer',
                    'Import/Export & Customs Clearing Agent'
                ],
                'Office & Administrative Support' => [
                    'Virtual Assistant (Data Entry, Email Management)',
                    'Translation & Transcription Services (Sinhala, Tamil, English)',
                    'Notary Public & Document Attestation Services',
                    'Company Registration & BOI Approval Assistance',
                    'Courier & Document Delivery Services',
                    'Temporary Staffing & Secretarial Services'
                ]
            ],
            'AGRICULTURE INDUSTRY' => [
                'Farming Operations' => [
                    'Tractor, Harvester & Rotavator Hire with Operator',
                    'Land Preparation, Plowing & Leveling',
                    'Well Digging, Borehole Drilling & Irrigation Installation',
                    'Greenhouse & Polyhouse Construction',
                    'Agricultural Drone Spraying & Mapping Services'
                ],
                'Crop & Livestock Management' => [
                    'Agricultural Consultant (Soil Testing, Crop Advice)',
                    'Organic Farming & Certification Consultant',
                    'Pest, Disease & Weed Management (Fumigation)',
                    'Veterinary Services for Cattle, Poultry & Goats',
                    'Animal Feed Supply & Nutritionist',
                    'Fruit & Vegetable Harvesting Labor Services',
                    'Aquaculture & Fisheries Management',
                    'Apiary (Beekeeping) Management Services'
                ]
            ],
            'EDUCATION & TUTORING INDUSTRY' => [
                'General Tutoring' => [
                    'Online & At-Home Academic Tutoring (All Grades & Subjects)',
                    'University & Advanced Level Exam Revision',
                    'IT & Computer Literacy Classes',
                    'Language Classes (English, Sinhala, Tamil, Korean, Chinese)',
                    'Professional Certificate Course Instructor',
                    'Early Childhood Education & Daycare Services',
                    'Special Needs Education & Support',
                    'Career Counseling & University Admission Guidance'
                ]
            ],
            'POLITICAL INDUSTRY IN SRI LANKA' => [
                'Political Campaign & Strategy' => [
                    'Political Campaign Manager & Strategist',
                    'Public Relations (PR) & Media Management for Politicians',
                    'Speechwriting & Communication Coaching',
                    'Political Event Organizer & Rally Management',
                    'Voter Data Analysis & Demographic Research',
                    'Grassroots Mobilization & Canvassing Services'
                ],
                'Digital & Creative Services for Politics' => [
                    'Political Social Media Management & Advertising',
                    'Campaign Video & Content Creation',
                    'Political Website Development & Digital Strategy',
                    'Opposition Research & Policy Analysis'
                ],
                'Logistics & Security' => [
                    'Political Event Security Services',
                    'Logistics & Transportation for Campaigns',
                    'Printing Services (Banners, Flyers, Posters)'
                ]
            ],
            'NON-PROFIT ORGANIZATIONS (NGOs) IN SRI LANKA' => [
                'NGO Support Services' => [
                    'Grant Proposal Writer & Fundraising Consultant',
                    'NGO Registration & Legal Compliance Advisor',
                    'M&E (Monitoring & Evaluation) Specialist',
                    'Donor Relationship Management',
                    'Non-Profit Accounting & Financial Management',
                    'CSR (Corporate Social Responsibility) Project Manager'
                ],
                'Community & Social Services' => [
                    'Disaster Relief & Emergency Response Coordination',
                    'Community Mobilizer & Social Worker',
                    'Vocational Training & Skills Development Instructor',
                    'Child Protection & Welfare Services',
                    'Women' . "'" . 's Empowerment Program Facilitator',
                    'Environmental Conservation & Awareness Programmes',
                    'Refugee & IDP (Internally Displaced Persons) Support',
                    'Human Rights Advocacy & Legal Aid Services',
                    'Public Health Awareness Campaign Organizer'
                ]
            ]
        ];

        $this->db->trans_start();
        $admin_id = $this->aauth->get_user()->id;

        foreach ($data as $industry => $subgroups) {
            // 1. Insert Industry as Main Category (c_type=0)
            $this->db->insert('tp_service_categories', [
                'title' => $industry,
                'c_type' => 0,
                'rel_id' => 0,
                'icon' => 'fa-industry', // Generic icon, can be updated later
                'status' => 1,
                'requested_by' => $admin_id
            ]);
            $industry_id = $this->db->insert_id();

            foreach ($subgroups as $subgroup => $services) {
                // 2. Insert Subgroup as Category (c_type=1)
                $this->db->insert('tp_service_categories', [
                    'title' => $subgroup,
                    'c_type' => 1,
                    'rel_id' => $industry_id,
                    'icon' => 'fa-folder',
                    'status' => 1,
                    'requested_by' => $admin_id
                ]);
                $subgroup_id = $this->db->insert_id();

                foreach ($services as $service) {
                    // 3. Insert Service into tp_services
                    $this->db->insert('tp_services', [
                        'service_name' => $service,
                        'cat_id' => $industry_id,
                        'sub_cat_id' => $subgroup_id,
                        'admin_commission_pc' => 10, // Default 10%
                        'status' => 1
                    ]);
                }
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            echo "Migration Failed!";
        } else {
            echo "Successfully migrated 12 industries and " . count($data, COUNT_RECURSIVE) . " services/groups.";
        }
    }
}
