<?php
// app/Http/Controllers/LearnController.php

namespace App\Http\Controllers;

use App\Core\Controller;

/**
 * LearnController
 * 
 * Handles learning resources and support pages for Wildlife Haven
 */
class LearnController extends Controller
{
    /**
     * Display support page
     * 
     * @return void
     */
    public function support()
    {
        // Prepare support categories and resources
        $supportCategories = [
            'Getting Started' => [
                [
                    'title' => 'What is Wildlife Haven?',
                    'description' => 'Learn about our app\'s mission to combine productivity with wildlife conservation.',
                    'icon' => 'info-circle'
                ],
                [
                    'title' => 'How Focus Sessions Work',
                    'description' => 'Understand how your focus time helps grow virtual creatures.',
                    'icon' => 'clock'
                ],
                [
                    'title' => 'Creating Your First Creature',
                    'description' => 'Step-by-step guide to hatching and nurturing your first virtual wildlife companion.',
                    'icon' => 'egg'
                ]
            ],
            'Technical Help' => [
                [
                    'title' => 'Account Management',
                    'description' => 'How to manage your account, change password, and link social accounts.',
                    'icon' => 'user-settings'
                ],
                [
                    'title' => 'App Connectivity',
                    'description' => 'Troubleshooting connection and synchronization issues.',
                    'icon' => 'wifi'
                ],
                [
                    'title' => 'Device Compatibility',
                    'description' => 'Check if your device supports Wildlife Haven\'s features.',
                    'icon' => 'devices'
                ]
            ],
            'Frequently Asked Questions' => [
                [
                    'title' => 'How do I earn coins?',
                    'description' => 'Learn about different ways to earn and use in-app currency.',
                    'icon' => 'coins'
                ],
                [
                    'title' => 'Conservation Impact',
                    'description' => 'Understand how your focus time contributes to real-world conservation.',
                    'icon' => 'tree'
                ],
                [
                    'title' => 'Creature Evolution',
                    'description' => 'Details on how creatures grow and change.',
                    'icon' => 'growth'
                ]
            ]
        ];

        // Contact support options
        $contactOptions = [
            [
                'method' => 'Email',
                'detail' => 'support@wildlifehaven.com',
                'icon' => 'mail'
            ],
            [
                'method' => 'Community Forum',
                'detail' => 'Connect with other users and get help',
                'icon' => 'message-circle'
            ],
            [
                'method' => 'Social Media',
                'detail' => '@WildlifeHavenApp',
                'icon' => 'at-sign'
            ]
        ];

        $data = [
            'supportCategories' => $supportCategories,
            'contactOptions' => $contactOptions,
            'baseUrl' => '/Wildlife'
        ];
        
        $this->render('learn/support', $data);
    }

    /**
     * Display FAQ details
     * 
     * @param array $params Route parameters
     * @return void
     */
    public function faq($params)
    {
        $faqCategory = $params['category'] ?? 'general';
        
        $faqs = [
            'general' => [
                [
                    'question' => 'What is Wildlife Haven?',
                    'answer' => 'Wildlife Haven is a unique productivity app that combines focus training with virtual wildlife conservation. As you stay focused and complete work sessions, you grow and nurture virtual creatures while contributing to real-world conservation efforts.'
                ],
                [
                    'question' => 'How does the conservation impact work?',
                    'answer' => 'For every focus session you complete, Wildlife Haven partners with conservation organizations to plant trees, protect habitats, or support wildlife preservation. Your productivity directly translates into real-world environmental impact.'
                ]
            ],
            'creatures' => [
                [
                    'question' => 'How do I hatch a creature?',
                    'answer' => 'Start focus sessions to warm and hatch your egg. Each successful session brings your egg closer to hatching. Once fully warmed, you can name and hatch your creature.'
                ],
                [
                    'question' => 'What happens if I get distracted during a focus session?',
                    'answer' => 'Distractions can pause or reset your egg\'s progress. Stay focused to successfully hatch and grow your creature!'
                ]
            ],
            'focus' => [
                [
                    'question' => 'How are focus sessions measured?',
                    'answer' => 'Focus sessions are typically 25 minutes long, following the Pomodoro technique. Our AI tracks your focus quality through device sensors, providing a Focus Score.'
                ],
                [
                    'question' => 'Can I customize session lengths?',
                    'answer' => 'Yes! While the default is 25 minutes, you can adjust session lengths to suit your work style and preferences.'
                ]
            ]
        ];

        $data = [
            'faqs' => $faqs[$faqCategory] ?? $faqs['general'],
            'currentCategory' => $faqCategory,
            'baseUrl' => '/Wildlife'
        ];

        $this->render('learn/faq', $data);
    }
}