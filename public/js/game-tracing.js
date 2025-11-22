// ========================================
// WELCOME ANIMATION (WAJIB)
// ========================================
window.addEventListener('DOMContentLoaded', function() {
    const backdrop = document.getElementById('welcome-backdrop');
    const message = document.getElementById('welcome-message');
    
    setTimeout(() => {
        backdrop.classList.remove('opacity-0');
        backdrop.classList.add('opacity-70');
        message.classList.remove('opacity-0');
        message.classList.add('opacity-100');
    }, 100);
    
    setTimeout(() => {
        backdrop.classList.remove('opacity-70');
        backdrop.classList.add('opacity-0');
        message.classList.remove('opacity-100');
        message.classList.add('opacity-0');
        
        setTimeout(() => {
            initGame();
        }, 500);
    }, 2500);
});

// ========================================
// DATA GAME - HURUF HIJAIYAH (MULTI-STROKE + CIRCLE)
// ========================================
const allHijaiyahData = [
    {
        id: 1,
        arabic: 'ا',
        name: 'Alif',
        difficulty: 'easy',
        image_path: '/images/hijaiyah/alif.webp',
        strokes: [
            {
                type: 'line',
                points: [
                    { x: 200, y: 80 },
                    { x: 200, y: 220 }
                ]
            }
        ]
    },
    {
        id: 2,
        arabic: 'ب',
        name: 'Ba',
        difficulty: 'easy',
        image_path: '/images/hijaiyah/ba.webp',
        strokes: [
            {
                type: 'line',
                points: [
                    { x: 290, y: 140 },
                    { x: 270, y: 200 },
                    { x: 200, y: 220 },
                    { x: 130, y: 200 },
                    { x: 100, y: 140 }
                ]
            },
            {
                type: 'circle',
                center: { x: 200, y: 240 },
                radius: 10
            }
        ]
    },
    {
        id: 3,
        arabic: 'ت',
        name: 'Ta',
        difficulty: 'easy',
        image_path: '/images/hijaiyah/ta.webp',
        strokes: [
            {
                type: 'line',
                points: [
                    { x: 290, y: 140 },
                    { x: 270, y: 200 },
                    { x: 200, y: 220 },
                    { x: 130, y: 200 },
                    { x: 100, y: 140 }
                ]
            },
            {
                type: 'circle',
                center: { x: 180, y: 120 },
                radius: 8
            },
            {
                type: 'circle',
                center: { x: 220, y: 120 },
                radius: 8
            }
        ]
    },
    {
        id: 4,
        arabic: 'ث',
        name: 'Tsa',
        difficulty: 'easy',
        image_path: '/images/hijaiyah/tsa.webp',
        strokes: [
            {
                type: 'line',
                points: [
                    { x: 280, y: 140 },
                    { x: 250, y: 190 },
                    { x: 200, y: 210 },
                    { x: 150, y: 190 },
                    { x: 120, y: 140 }
                ]
            },
            {
                type: 'circle',
                center: { x: 180, y: 120 },
                radius: 8
            },
            {
                type: 'circle',
                center: { x: 200, y: 105 },
                radius: 8
            },
            {
                type: 'circle',
                center: { x: 220, y: 120 },
                radius: 8
            }
        ]
    },
    {
        id: 5,
        arabic: 'ج',
        name: 'Jim',
        difficulty: 'medium',
        image_path: '/images/hijaiyah/jim.webp',
        strokes: [
            {
                type: 'line',
                points: [
                    { x: 120, y: 100 },
                    { x: 200, y: 90 },
                    { x: 280, y: 100 },
                    { x: 200, y: 120 },
                    { x: 130, y: 130 },
                    { x: 120, y: 150 },
                    { x: 130, y: 170 },
                    { x: 170, y: 200 },
                    { x: 220, y: 210 },
                    { x: 260, y: 200 }
                ]
            },
            {
                type: 'circle',
                center: { x: 200, y: 150 },
                radius: 8
            }
        ]
    },
    {
        id: 6,
        arabic: 'ح',
        name: 'Ha',
        difficulty: 'medium',
        image_path: '/images/hijaiyah/ha.webp',
        strokes: [
            {
                type: 'line',
                points: [
                    { x: 120, y: 100 },
                    { x: 200, y: 90 },
                    { x: 280, y: 100 },
                    { x: 200, y: 120 },
                    { x: 130, y: 130 },
                    { x: 120, y: 150 },
                    { x: 130, y: 170 },
                    { x: 170, y: 200 },
                    { x: 220, y: 210 },
                    { x: 260, y: 200 }
                ]
            }
        ]
    },
    {
        id: 7,
        arabic: 'خ',
        name: 'Kha',
        difficulty: 'medium',
        image_path: '/images/hijaiyah/kha.webp',
        strokes: [
            {
                type: 'line',
                points: [
                    { x: 120, y: 100 },
                    { x: 200, y: 90 },
                    { x: 280, y: 100 },
                    { x: 200, y: 120 },
                    { x: 130, y: 130 },
                    { x: 120, y: 150 },
                    { x: 130, y: 170 },
                    { x: 170, y: 200 },
                    { x: 220, y: 210 },
                    { x: 260, y: 200 }
                ]
            },
            {
                type: 'circle',
                center: { x: 190, y: 65 },
                radius: 8
            }
        ]
    },
    {
        id: 8,
        arabic: 'د',
        name: 'Dal',
        difficulty: 'easy',
        image_path: '/images/hijaiyah/dal.webp',
        strokes: [
            {
                type: 'line',
                points: [
                    { x: 200, y: 110 },
                    { x: 240, y: 130 },
                    { x: 260, y: 160 },
                    { x: 240, y: 200 },
                    { x: 160, y: 200 },
                    { x: 140, y: 160 }
                ]
            }
        ]
    },
    {
        id: 9,
        arabic: 'ذ',
        name: 'Dzal',
        difficulty: 'easy',
        image_path: '/images/hijaiyah/dzal.webp',
        strokes: [
            {
                type: 'line',
                points: [
                    { x: 200, y: 110 },
                    { x: 240, y: 130 },
                    { x: 260, y: 160 },
                    { x: 240, y: 200 },
                    { x: 160, y: 200 },
                    { x: 140, y: 160 }
                ]
            },
            {
                type: 'circle',
                center: { x: 190, y: 75 },
                radius: 8
            }
        ]
    },
    {
        id: 10,
        arabic: 'ر',
        name: 'Ra',
        difficulty: 'easy',
        image_path: '/images/hijaiyah/ra.webp',
        strokes: [
            {
                type: 'line',
                points: [
                    { x: 220, y: 120 },
                    { x: 230, y: 150 },
                    { x: 220, y: 180 },
                    { x: 200, y: 190 },
                    { x: 180, y: 180 },
                ]
            }
        ]
    },
    {
        id: 11,
        arabic: 'ز',
        name: 'Zai',
        difficulty: 'easy',
        image_path: '/images/hijaiyah/zai.webp',
        strokes: [
            {
                type: 'line',
                points: [
                    { x: 220, y: 120 },
                    { x: 230, y: 150 },
                    { x: 220, y: 180 },
                    { x: 200, y: 190 },
                    { x: 180, y: 180 },
                ]
            },
            {
                type: 'circle',
                center: { x: 220, y: 85 },
                radius: 7
            }
        ]
    },
    {
        id: 12,
        arabic: 'س',
        name: 'Sin',
        difficulty: 'medium',
        image_path: '/images/hijaiyah/sin.webp',
        strokes: [
            {
                type: 'line',
                points: [
                    { x: 280, y: 140 },
                    { x: 280, y: 150 },
                    { x: 260, y: 160 },
                    { x: 240, y: 150 },
                    { x: 240, y: 140 },
                    { x: 240, y: 150 },
                    { x: 220, y: 160 },
                    { x: 200, y: 150 },
                    { x: 200, y: 140 },
                    { x: 200, y: 150 },
                    { x: 190, y: 160 },
                    { x: 180, y: 170 },
                    { x: 170, y: 180 },
                    { x: 150, y: 190 },
                    { x: 120, y: 180 },
                    { x: 110, y: 170 },
                    { x: 110, y: 160 }
                ]
            }
        ]
    },
    {
        id: 13,
        arabic: 'ش',
        name: 'Syin',
        difficulty: 'medium',
        image_path: '/images/hijaiyah/syin.webp',
        strokes: [
            {
                type: 'line',
                points: [
                    { x: 280, y: 140 },
                    { x: 280, y: 150 },
                    { x: 260, y: 160 },
                    { x: 240, y: 150 },
                    { x: 240, y: 140 },
                    { x: 240, y: 150 },
                    { x: 220, y: 160 },
                    { x: 200, y: 150 },
                    { x: 200, y: 140 },
                    { x: 200, y: 150 },
                    { x: 190, y: 160 },
                    { x: 180, y: 170 },
                    { x: 170, y: 180 },
                    { x: 150, y: 190 },
                    { x: 120, y: 180 },
                    { x: 110, y: 170 },
                    { x: 110, y: 160 }
                ]
            },
            {
                type: 'circle',
                center: { x: 220, y: 105 },
                radius: 6
            },
            {
                type: 'circle',
                center: { x: 240, y: 90 },
                radius: 6
            },
            {
                type: 'circle',
                center: { x: 260, y: 105 },
                radius: 6
            }
        ]
    },
    {
        id: 14,
        arabic: 'ص',
        name: 'Shad',
        difficulty: 'medium',
        image_path: '/images/hijaiyah/shad.webp',
        strokes: [
            {
                type: 'line',
                points: [
                    { x: 200, y: 140 },
                    { x: 210, y: 130 },
                    { x: 240, y: 120 },
                    { x: 270, y: 130 },
                    { x: 280, y: 140 },
                    { x: 270, y: 150 },
                    { x: 240, y: 160 },
                    { x: 200, y: 150 },
                    { x: 200, y: 140 },
                    { x: 200, y: 120 },
                    { x: 200, y: 140 },
                    { x: 200, y: 150 },
                    { x: 200, y: 150 },
                    { x: 190, y: 160 },
                    { x: 180, y: 170 },
                    { x: 170, y: 180 },
                    { x: 150, y: 190 },
                    { x: 120, y: 180 },
                    { x: 110, y: 170 },
                    { x: 110, y: 160 }
                ]
            }
        ]
    },
    {
        id: 15,
        arabic: 'ض',
        name: 'Dhad',
        difficulty: 'medium',
        image_path: '/images/hijaiyah/dhad.webp',
        strokes: [
            {
                type: 'line',
                points: [
                    { x: 200, y: 140 },
                    { x: 210, y: 130 },
                    { x: 240, y: 120 },
                    { x: 270, y: 130 },
                    { x: 280, y: 140 },
                    { x: 270, y: 150 },
                    { x: 240, y: 160 },
                    { x: 200, y: 150 },
                    { x: 200, y: 140 },
                    { x: 200, y: 120 },
                    { x: 200, y: 140 },
                    { x: 200, y: 150 },
                    { x: 200, y: 150 },
                    { x: 190, y: 160 },
                    { x: 180, y: 170 },
                    { x: 170, y: 180 },
                    { x: 150, y: 190 },
                    { x: 120, y: 180 },
                    { x: 110, y: 170 },
                    { x: 110, y: 160 }
                ]
            },
            {
                type: 'circle',
                center: { x: 240, y: 100 },
                radius: 6
            }
        ]
    },
    {
        id: 16,
        arabic: 'ط',
        name: 'Tha',
        difficulty: 'medium',
        image_path: '/images/hijaiyah/tha.webp',
        strokes: [
            {
                type: 'line',
                points: [
                    { x: 190, y: 80 },
                    { x: 190, y: 160 },
                    { x: 190, y: 150 },
                    { x: 200, y: 140 },
                    { x: 230, y: 130 },
                    { x: 260, y: 140 },
                    { x: 270, y: 150 },
                    { x: 260, y: 160 },
                    { x: 230, y: 160 },
                    { x: 190, y: 160 },
                    // { x: 190, y: 150 },
                    { x: 170, y: 160 },
                ]
            },
            
        ]
    },
    {
        id: 17,
        arabic: 'ظ',
        name: 'Dza',
        difficulty: 'medium',
        image_path: '/images/hijaiyah/dza.webp',
        strokes: [
            {
                type: 'line',
                points: [
                    { x: 190, y: 80 },
                    { x: 190, y: 160 },
                    { x: 190, y: 150 },
                    { x: 200, y: 140 },
                    { x: 230, y: 130 },
                    { x: 260, y: 140 },
                    { x: 270, y: 150 },
                    { x: 260, y: 160 },
                    { x: 230, y: 160 },
                    { x: 190, y: 160 },
                    // { x: 190, y: 150 },
                    { x: 170, y: 160 },
                ]
            },
            {
                type: 'circle',
                center: { x: 230, y: 110 },
                radius: 6
            }
        ]
    },
    {
        id: 18,
        arabic: 'ع',
        name: 'Ain',
        difficulty: 'hard',
        image_path: '/images/hijaiyah/ain.webp',
        strokes: [
            {
                type: 'line',
                points: [
                    { x: 190, y: 115 },
                    { x: 170, y: 105 },  // MELENGKUNG KIRI ATAS
                    { x: 150, y: 100 },
                    { x: 140, y: 120 },
                    { x: 150, y: 140 },
                    { x: 190, y: 125 },  // BALIK KE TENGAH
                    { x: 150, y: 140 },  // MELENGKUNG KANAN BAWAH
                    { x: 140, y: 160 },
                    { x: 132, y: 180 },
                    { x: 130, y: 180 },
                    { x: 140, y: 185 },
                    { x: 150, y: 195 },
                    { x: 160, y: 200 },
                    { x: 180, y: 210 },
                    { x: 200, y: 200 }
                ]
            }
        ]
    },
    {
        id: 19,
        arabic: 'غ',
        name: 'Ghain',
        difficulty: 'hard',
        image_path: '/images/hijaiyah/ghain.webp',
        strokes: [
            {
                type: 'line',
                points: [
                    { x: 190, y: 115 },
                    { x: 170, y: 105 },  // MELENGKUNG KIRI ATAS
                    { x: 150, y: 100 },
                    { x: 140, y: 120 },
                    { x: 150, y: 140 },
                    { x: 190, y: 125 },  // BALIK KE TENGAH
                    { x: 150, y: 140 },  // MELENGKUNG KANAN BAWAH
                    { x: 140, y: 160 },
                    { x: 132, y: 180 },
                    { x: 130, y: 180 },
                    { x: 140, y: 185 },
                    { x: 150, y: 195 },
                    { x: 160, y: 200 },
                    { x: 180, y: 210 },
                    { x: 200, y: 200 }
                ]
            },
            {
                type: 'circle',
                center: { x: 160, y: 70 },
                radius: 6
            }
        ]
    },
    {
        id: 20,
        arabic: 'ف',
        name: 'Fa',
        difficulty: 'medium',
        image_path: '/images/hijaiyah/fa.webp',
        strokes: [
            {
                type: 'line',
                points: [
                    { x: 250, y: 150 },
                    { x: 230, y: 155 },
                    { x: 205, y: 150 },
                    { x: 210, y: 120 },
                    { x: 230, y: 110 },
                    { x: 250, y: 110 },
                    { x: 250, y: 150 },
                    { x: 230, y: 180 },
                    { x: 200, y: 190 },
                    { x: 170, y: 185 },
                    { x: 150, y: 175 },
                    { x: 140, y: 170 },
                    { x: 130, y: 165 },
                    { x: 120, y: 160 }
                ]
            },
            {
                type: 'circle',
                center: { x: 230, y: 85 },
                radius: 8
            }
        ]
    },
    {
        id: 21,
        arabic: 'ق',
        name: 'Qaf',
        difficulty: 'medium',
        image_path: '/images/hijaiyah/qaf.webp',
        strokes: [
            {
                type: 'line',
                points: [
                    { x: 250, y: 150 },
                    { x: 230, y: 155 },
                    { x: 205, y: 150 },
                    { x: 210, y: 120 },
                    { x: 230, y: 110 },
                    { x: 250, y: 110 },
                    { x: 250, y: 150 },
                    { x: 230, y: 180 },
                    { x: 200, y: 190 },
                    { x: 170, y: 185 },
                    { x: 150, y: 175 },
                    { x: 140, y: 170 },
                    { x: 130, y: 165 },
                    { x: 120, y: 160 }
                ]
            },
            {
                type: 'circle',
                center: { x: 240, y: 85 },
                radius: 6
            },
            {
                type: 'circle',
                center: { x: 215, y: 85 },
                radius: 6
            }
        ]
    },
    {
        id: 22,
        arabic: 'ك',
        name: 'Kaf',
        difficulty: 'medium',
        image_path: '/images/hijaiyah/kaf.webp',
        strokes: [
            {
                type: 'line',
                points: [
                    { x: 240, y: 80 },
                    { x: 240, y: 210 },
                    { x: 235, y: 212 },
                    { x: 230, y: 220 },
                    { x: 150, y: 220 },   
                    { x: 145, y: 210 }
                ]
            },
            {
                type: 'line',
                points: [
                    { x: 200, y: 150 },
                    { x: 180, y: 160 },
                    { x: 195, y: 165 },
                    { x: 180, y: 170 }
                ]
            }
        ]
    },
    {
        id: 23,
        arabic: 'ل',
        name: 'Lam',
        difficulty: 'easy',
        image_path: '/images/hijaiyah/lam.webp',
        strokes: [
            {
                type: 'line',
                points: [
                    { x: 240, y: 120 },
                    { x: 240, y: 200 },
                    { x: 230, y: 210 },
                    { x: 210, y: 214 },
                    { x: 200, y: 212 },
                    { x: 190, y: 212 },
                    { x: 160, y: 210 },
                    { x: 160, y: 200 }
                ]
            }
        ]
    },
    {
        id: 24,
        arabic: 'م',
        name: 'Mim',
        difficulty: 'medium',
        image_path: '/images/hijaiyah/mim.webp',
        strokes: [
            {
                type: 'line',
                points: [
                    { x: 180, y: 105 },
                    { x: 190, y: 100 },
                    { x: 205, y: 90 },
                    { x: 210, y: 95 },
                    { x: 230, y: 100 },
                    { x: 230, y: 105 },
                    { x: 200, y: 110 },
                    { x: 180, y: 115 },
                    { x: 190, y: 180 },
                ]
            }
        ]
    },
    {
        id: 25,
        arabic: 'ن',
        name: 'Nun',
        difficulty: 'medium',
        image_path: '/images/hijaiyah/nun.webp',
        strokes: [
            {
                type: 'line',
                points: [
                    { x: 290, y: 140 },
                    { x: 270, y: 200 },
                    { x: 200, y: 220 },
                    { x: 130, y: 200 },
                    { x: 100, y: 140 }
                ]
            },
            {
                type: 'circle',
                center: { x: 200, y: 150 },
                radius: 8
            }
        ]
    },
    {
        id: 26,
        arabic: 'و',
        name: 'Wau',
        difficulty: 'easy',
        image_path: '/images/hijaiyah/wau.webp',
        strokes: [
            {
                type: 'line',
                points: [
                    { x: 220, y: 130 },
                    { x: 200, y: 140 },
                    { x: 180, y: 120 },
                    { x: 180, y: 100 },
                    { x: 200, y: 90 },
                    { x: 220, y: 100 },
                    { x: 220, y: 140 },
                    { x: 210, y: 160 },
                    { x: 185, y: 185 },
                    { x: 155, y: 175 },
                    { x: 135, y: 155 }
                ]
            }
        ]
    },
    {
        id: 27,
        arabic: 'ه',
        name: 'Ha',
        difficulty: 'medium',
        image_path: '/images/hijaiyah/haa.webp',
        strokes: [
            {
                type: 'line',
                points: [
                    { x: 200, y: 100 },
                    { x: 220, y: 120 },
                    { x: 230, y: 150 },
                    { x: 220, y: 180 },
                    { x: 200, y: 185 },
                    { x: 180, y: 180 },
                    { x: 170, y: 150 },
                    { x: 180, y: 120 },
                    { x: 200, y: 100 }
                ]
            }
        ]
    },
    {
        id: 28,
        arabic: 'لا',
        name: 'Lamalif',
        difficulty: 'medium',
        image_path: '/images/hijaiyah/Lamalif.webp',
        strokes: [
            {
                type: 'line',
                points: [
                    { x: 240, y: 120 },
                    { x: 200, y: 170 },
                    { x: 160, y: 200 },
                    { x: 160, y: 205 },
                    { x: 180, y: 210 },
                    { x: 230, y: 200 },
                    { x: 230, y: 195 },
                    { x: 200, y: 170 },
                    { x: 160, y: 140 }
                ]
            },
            {
                type: 'line',
                center: { x: 190, y: 195 },
                radius: 8
            }
        ]
    },
    {
        id: 29,
        arabic: 'ء',
        name: 'Hamzah',
        difficulty: 'easy',
        image_path: '/images/hijaiyah/hamzah.webp',
        strokes: [
            {
                type: 'line',
                points: [
                    { x: 210, y: 135 },
                    { x: 190, y: 125 },  // MELENGKUNG KIRI ATAS
                    { x: 170, y: 120 },
                    { x: 160, y: 140 },
                    { x: 170, y: 160 },
                    { x: 210, y: 165 },  // BALIK KE TENGAH
                    { x: 155, y: 170 },
                ]
            }
        ]   
    },
    {
        arabic: 'ي',
        name: 'Ya',
        difficulty: 'medium',
        image_path: '/images/hijaiyah/ya.webp',
        strokes: [
            {
                type: 'line',
                points: [
                    { x: 270, y: 120 },
                    { x: 250, y: 125 },
                    { x: 215, y: 140 },
                    { x: 210, y: 152 },
                    { x: 220, y: 155 },
                    { x: 260, y: 175 },
                    { x: 255, y: 180 },
                    { x: 250, y: 200 },
                    { x: 200, y: 210 },
                    { x: 175, y: 205 },
                    { x: 150, y: 205 },
                    { x: 140, y: 195 }
                ]
            },
            {
                type: 'circle',
                center: { x: 180, y: 225 },
                radius: 7
            },
            {
                type: 'circle',
                center: { x: 215, y: 225 },
                radius: 7
            }
        ]
    }
];

// ========================================
// GAME SETTINGS
// ========================================
const settings = {
    canvasWidth: 400,
    canvasHeight: 300,
    lineWidth: 5,
    tolerance: 30,
    colors: {
        correct: '#4CAF50',
        incorrect: '#F44336',
        guide: '#E0E0E0',
        guideCircle: '#CCE5FF',
        stroke: '#2196F3',
        background: 'white',
        completed: '#9E9E9E'
    },
    scoring: {
        threeStars: 90,
        twoStars: 70,
        oneStar: 50
    }
    // hai
};

// ========================================
// GAME STATE
// ========================================
let currentHurufIndex = 0;
let currentStrokeIndex = 0;
let gameState = {
    isDrawing: false,
    completedStrokes: [],
    currentStrokeProgress: 0,
    currentStrokeAccuracy: 0,
    tracedPoints: [],
    totalPoints: 0,
    correctPoints: 0,
    circleClicked: false,
    totalGamePoints: 0, 
    totalGameCorrectPoints: 0,
};

let guideCanvas, guideCtx;
let tracingCanvas, tracingCtx;
let animationCanvas, animationCtx;

// ========================================
// INITIALIZE GAME
// ========================================
function initGame() {
    guideCanvas = document.getElementById('guideCanvas');
    guideCtx = guideCanvas.getContext('2d');
    tracingCanvas = document.getElementById('tracingCanvas');
    tracingCtx = tracingCanvas.getContext('2d');
    animationCanvas = document.getElementById('animationCanvas');
    animationCtx = animationCanvas.getContext('2d');

    setupEventListeners();
    loadGame(currentHurufIndex);
}

// ========================================
// SETUP EVENT LISTENERS
// ========================================
function setupEventListeners() {
    tracingCanvas.addEventListener('mousedown', startDrawing);
    tracingCanvas.addEventListener('mousemove', draw);
    tracingCanvas.addEventListener('mouseup', stopDrawing);
    tracingCanvas.addEventListener('mouseleave', stopDrawing);
    tracingCanvas.addEventListener('click', handleCanvasClick);

    tracingCanvas.addEventListener('touchstart', handleTouchStart);
    tracingCanvas.addEventListener('touchmove', handleTouchMove);
    tracingCanvas.addEventListener('touchend', stopDrawing);

    document.getElementById('clear-button').addEventListener('click', clearCanvas);
    document.getElementById('replay-button').addEventListener('click', playAnimation);
    
    // UDAH ADA DI BLADE
    document.getElementById('prev-button').addEventListener('click', loadPreviousLetter);
    document.getElementById('next-button').addEventListener('click', loadNextLetter);
    
    // document.getElementById('try-again-button').addEventListener('click', restartCurrentLetter);
    //document.getElementById('next-letter-button').addEventListener('click', loadNextLetter);
}

// ========================================
// LOAD GAME WITH SPECIFIC LETTER
// ========================================
function loadGame(index) {
    if (index < 0 || index >= allHijaiyahData.length) return;

    currentHurufIndex = index;
    currentStrokeIndex = 0;
    const letter = allHijaiyahData[index];

    document.getElementById('current-letter-arabic').textContent = letter.arabic;
    document.getElementById('current-letter-name').textContent = letter.name;
    document.getElementById('letter-display').textContent = letter.arabic;

    gameState = {
        isDrawing: false,
        completedStrokes: [],
        currentStrokeProgress: 0,
        currentStrokeAccuracy: 0,
        tracedPoints: [],
        totalPoints: 0,
        correctPoints: 0,
        circleClicked: false,
        totalGamePoints: 0, 
        totalGameCorrectPoints: 0,
    };

    drawGuide(letter);
    clearCanvas();
    playAnimation();
    updateProgress();
    updateNavigationButtons();
}

// ========================================
// DRAW GUIDE PATH (MULTI-STROKE + CIRCLE)
// ========================================
function drawGuide(letter) {
    guideCtx.clearRect(0, 0, guideCanvas.width, guideCanvas.height);
    guideCtx.fillStyle = settings.colors.background;
    guideCtx.fillRect(0, 0, guideCanvas.width, guideCanvas.height);

    if (!letter.strokes || letter.strokes.length === 0) {
        guideCtx.fillStyle = '#666';
        guideCtx.font = '16px Arial';
        guideCtx.textAlign = 'center';
        guideCtx.fillText('Strokes belum didefinisikan', 200, 150);
        return;
    }

    letter.strokes.forEach((stroke, index) => {
        const isCompleted = gameState.completedStrokes.includes(index);
        const isCurrent = index === currentStrokeIndex;
        
        if (stroke.type === 'line') {
            guideCtx.strokeStyle = isCompleted ? settings.colors.completed : 
                                   isCurrent ? settings.colors.guide : '#F0F0F0';
            guideCtx.lineWidth = settings.lineWidth;
            guideCtx.lineCap = 'round';
            guideCtx.lineJoin = 'round';
            guideCtx.setLineDash(isCurrent ? [10, 10] : []);

            guideCtx.beginPath();
            guideCtx.moveTo(stroke.points[0].x, stroke.points[0].y);
            for (let i = 1; i < stroke.points.length; i++) {
                guideCtx.lineTo(stroke.points[i].x, stroke.points[i].y);
            }
            guideCtx.stroke();

            if (isCurrent) {
                guideCtx.fillStyle = '#4CAF50';
                guideCtx.beginPath();
                guideCtx.arc(stroke.points[0].x, stroke.points[0].y, 8, 0, Math.PI * 2);
                guideCtx.fill();

                guideCtx.fillStyle = '#F44336';
                guideCtx.beginPath();
                guideCtx.arc(stroke.points[stroke.points.length - 1].x, stroke.points[stroke.points.length - 1].y, 8, 0, Math.PI * 2);
                guideCtx.fill();
            }
        } else if (stroke.type === 'circle') {
            guideCtx.strokeStyle = isCompleted ? settings.colors.completed : 
                                   isCurrent ? settings.colors.guide : '#F0F0F0';
            guideCtx.lineWidth = 3;
            guideCtx.fillStyle = isCurrent ? settings.colors.guideCircle : '#F5F5F5';
            
            guideCtx.beginPath();
            guideCtx.arc(stroke.center.x, stroke.center.y, stroke.radius, 0, Math.PI * 2);
            guideCtx.fill();
            guideCtx.stroke();
        }
    });

    guideCtx.setLineDash([]);
}

// ========================================
// PLAY ANIMATION (ALL STROKES)
// ========================================
function playAnimation() {
    const letter = allHijaiyahData[currentHurufIndex];
    if (!letter || !letter.strokes || letter.strokes.length === 0) return;

    animationCtx.clearRect(0, 0, animationCanvas.width, animationCanvas.height);
    const scaleX = animationCanvas.width / guideCanvas.width;
    const scaleY = animationCanvas.height / guideCanvas.height;

    let strokeIndex = 0;
    let pointIndex = 0;
    let progress = 0;

    function animate() {
        if (strokeIndex >= letter.strokes.length) return;

        const stroke = letter.strokes[strokeIndex];
        
        if (stroke.type === 'circle') {
            // Draw circle immediately
            animationCtx.strokeStyle = settings.colors.stroke;
            animationCtx.lineWidth = settings.lineWidth;
            animationCtx.beginPath();
            animationCtx.arc(stroke.center.x * scaleX, stroke.center.y * scaleY, stroke.radius, 0, Math.PI * 2);
            animationCtx.stroke();
            
            strokeIndex++;
            setTimeout(() => requestAnimationFrame(animate), 300);
            return;
        }

        if (pointIndex >= stroke.points.length - 1) {
            strokeIndex++;
            pointIndex = 0;
            progress = 0;
            if (strokeIndex < letter.strokes.length) {
                setTimeout(() => requestAnimationFrame(animate), 300);
            }
            return;
        }

        const start = stroke.points[pointIndex];
        const end = stroke.points[pointIndex + 1];
        const x = start.x + (end.x - start.x) * progress;
        const y = start.y + (end.y - start.y) * progress;

        animationCtx.strokeStyle = settings.colors.stroke;
        animationCtx.lineWidth = settings.lineWidth;
        animationCtx.lineCap = 'round';
        animationCtx.lineJoin = 'round';

        if (progress === 0 && pointIndex === 0) {
            animationCtx.beginPath();
            animationCtx.moveTo(start.x * scaleX, start.y * scaleY);
        }

        animationCtx.lineTo(x * scaleX, y * scaleY);
        animationCtx.stroke();

        progress += 0.02;
        if (progress >= 1) {
            progress = 0;
            pointIndex++;
        }

        requestAnimationFrame(animate);
    }

    animate();
}

// ========================================
// HANDLE CANVAS CLICK (UNTUK CIRCLE)
// ========================================
function handleCanvasClick(e) {
    const letter = allHijaiyahData[currentHurufIndex];
    if (!letter || !letter.strokes) return;

    const stroke = letter.strokes[currentStrokeIndex];
    if (!stroke || stroke.type !== 'circle') return;

    const pos = getMousePos(e);
    const dx = pos.x - stroke.center.x;
    const dy = pos.y - stroke.center.y;
    const distance = Math.sqrt(dx * dx + dy * dy);

    if (distance <= stroke.radius + 10) {
        // Circle clicked successfully
        gameState.circleClicked = true;
        
        // Draw filled circle on canvas
        tracingCtx.fillStyle = settings.colors.correct;
        tracingCtx.beginPath();
        tracingCtx.arc(stroke.center.x, stroke.center.y, stroke.radius, 0, Math.PI * 2);
        tracingCtx.fill();

        gameState.currentStrokeProgress = 100;
        updateProgress();

        setTimeout(() => {
            advanceToNextStroke();
        }, 300);
    }
}

// ========================================
// DRAWING FUNCTIONS
// ========================================
function startDrawing(e) {
    const letter = allHijaiyahData[currentHurufIndex];
    if (!letter || !letter.strokes) return;

    const stroke = letter.strokes[currentStrokeIndex];
    if (stroke && stroke.type === 'circle') {
        // Jangan allow drawing untuk circle stroke
        return;
    }

    gameState.isDrawing = true;
    const pos = getMousePos(e);
    tracingCtx.beginPath();
    tracingCtx.moveTo(pos.x, pos.y);
}

function draw(e) {
    if (!gameState.isDrawing) return;

    const letter = allHijaiyahData[currentHurufIndex];
    if (!letter || !letter.strokes) return;

    const stroke = letter.strokes[currentStrokeIndex];
    if (stroke && stroke.type === 'circle') return;

    const pos = getMousePos(e);
    const isCorrect = checkAccuracy(pos);

    gameState.totalPoints++;
    if (isCorrect) {
        gameState.correctPoints++;
    }

    tracingCtx.strokeStyle = isCorrect ? settings.colors.correct : settings.colors.incorrect;
    tracingCtx.lineWidth = settings.lineWidth;
    tracingCtx.lineCap = 'round';
    tracingCtx.lineJoin = 'round';
    tracingCtx.lineTo(pos.x, pos.y);
    tracingCtx.stroke();

    tracingCtx.beginPath();
    tracingCtx.moveTo(pos.x, pos.y);

    gameState.tracedPoints.push({ x: pos.x, y: pos.y, correct: isCorrect });

    calculateProgress();
    updateProgress();
}

function stopDrawing() {
    if (!gameState.isDrawing) return;
    gameState.isDrawing = false;
    tracingCtx.beginPath();

    if (gameState.currentStrokeProgress >= 80) {
        setTimeout(() => {
            advanceToNextStroke();
        }, 300);
    }
}

function handleTouchStart(e) {
    e.preventDefault();
    const touch = e.touches[0];
    const mouseEvent = new MouseEvent('mousedown', {
        clientX: touch.clientX,
        clientY: touch.clientY
    });
    tracingCanvas.dispatchEvent(mouseEvent);
}

function handleTouchMove(e) {
    e.preventDefault();
    const touch = e.touches[0];
    const mouseEvent = new MouseEvent('mousemove', {
        clientX: touch.clientX,
        clientY: touch.clientY
    });
    tracingCanvas.dispatchEvent(mouseEvent);
}

// ========================================
// ADVANCE TO NEXT STROKE
// ========================================
function advanceToNextStroke() {
    const letter = allHijaiyahData[currentHurufIndex];

    // 1. Akumulasi skor dari goresan garis
    gameState.totalGamePoints += gameState.totalPoints;
    gameState.totalGameCorrectPoints += gameState.correctPoints;
    
    // 2. Jika stroke adalah circle, kita tambahkan skor tetap (misalnya 10 poin)
    if (letter.strokes[currentStrokeIndex].type === 'circle') {
         // Asumsi: Circle selalu benar dan bernilai 10 poin
         gameState.totalGamePoints += 10;
         gameState.totalGameCorrectPoints += 10;
    }

    gameState.completedStrokes.push(currentStrokeIndex);
    
    if (gameState.completedStrokes.length >= letter.strokes.length) {
        showSuccessScreen();
    } else {
        currentStrokeIndex++;
        gameState.tracedPoints = [];
        gameState.totalPoints = 0;
        gameState.correctPoints = 0;
        gameState.currentStrokeProgress = 0;
        gameState.circleClicked = false;
        drawGuide(letter);
        updateProgress();
    }
}

// ========================================
// GET MOUSE POSITION
// ========================================
function getMousePos(e) {
    const rect = tracingCanvas.getBoundingClientRect();
    const scaleX = tracingCanvas.width / rect.width;
    const scaleY = tracingCanvas.height / rect.height;

    return {
        x: (e.clientX - rect.left) * scaleX,
        y: (e.clientY - rect.top) * scaleY
    };
}

// ========================================
// CHECK ACCURACY (CURRENT STROKE ONLY)
// ========================================
function checkAccuracy(point) {
    const letter = allHijaiyahData[currentHurufIndex];
    if (!letter || !letter.strokes || currentStrokeIndex >= letter.strokes.length) return false;

    const stroke = letter.strokes[currentStrokeIndex];
    if (stroke.type !== 'line') return false;

    for (let i = 0; i < stroke.points.length - 1; i++) {
        const start = stroke.points[i];
        const end = stroke.points[i + 1];
        const distance = distanceToLineSegment(point, start, end);
        if (distance <= settings.tolerance) {
            return true;
        }
    }

    return false;
}

// ========================================
// DISTANCE TO LINE SEGMENT
// ========================================
function distanceToLineSegment(point, start, end) {
    const A = point.x - start.x;
    const B = point.y - start.y;
    const C = end.x - start.x;
    const D = end.y - start.y;

    const dot = A * C + B * D;
    const lenSq = C * C + D * D;
    let param = -1;

    if (lenSq !== 0) {
        param = dot / lenSq;
    }

    let xx, yy;

    if (param < 0) {
        xx = start.x;
        yy = start.y;
    } else if (param > 1) {
        xx = end.x;
        yy = end.y;
    } else {
        xx = start.x + param * C;
        yy = start.y + param * D;
    }

    const dx = point.x - xx;
    const dy = point.y - yy;
    return Math.sqrt(dx * dx + dy * dy);
}

// ========================================
// CALCULATE PROGRESS
// ========================================
function calculateProgress() {
    const letter = allHijaiyahData[currentHurufIndex];
    if (!letter || !letter.strokes || currentStrokeIndex >= letter.strokes.length) return;

    const stroke = letter.strokes[currentStrokeIndex];
    if (stroke.type !== 'line') return;

    const pathLength = calculatePathLength(stroke.points);

    let coveredLength = 0;
    const tracedPoints = gameState.tracedPoints;
    for (let i = 0; i < tracedPoints.length - 1; i++) {
        const p1 = tracedPoints[i];
        const p2 = tracedPoints[i + 1];
        const dist = Math.sqrt((p2.x - p1.x) ** 2 + (p2.y - p1.y) ** 2);
        coveredLength += dist;
    }

    gameState.currentStrokeProgress = Math.min(100, (coveredLength / pathLength) * 100);

    if (gameState.totalPoints > 0) {
        gameState.currentStrokeAccuracy = Math.round((gameState.correctPoints / gameState.totalPoints) * 100);
    }
}

// ========================================
// CALCULATE PATH LENGTH
// ========================================
function calculatePathLength(path) {
    let length = 0;
    for (let i = 0; i < path.length - 1; i++) {
        const p1 = path[i];
        const p2 = path[i + 1];
        length += Math.sqrt((p2.x - p1.x) ** 2 + (p2.y - p1.y) ** 2);
    }
    return length;
}

// ========================================
// UPDATE PROGRESS UI
// ========================================
function updateProgress() {
    const letter = allHijaiyahData[currentHurufIndex];
    const totalStrokes = letter.strokes ? letter.strokes.length : 1;
    const completedStrokes = gameState.completedStrokes.length;
    
    const overallProgress = ((completedStrokes + (gameState.currentStrokeProgress / 100)) / totalStrokes) * 100;

    const progressFill = document.getElementById('progress-fill');
    const progressText = document.getElementById('progress-text');
    const scoreDisplay = document.getElementById('score-display');
    const starsDisplay = document.getElementById('stars-display');

    progressFill.style.width = overallProgress + '%';
    progressText.textContent = Math.round(overallProgress) + '%';
    scoreDisplay.textContent = gameState.currentStrokeAccuracy + '%';

    const stars = getStars(gameState.currentStrokeAccuracy);
    starsDisplay.innerHTML = '⭐'.repeat(stars) + '☆'.repeat(3 - stars);
}

// ========================================
// GET STARS BASED ON ACCURACY
// ========================================
function getStars(accuracy) {
    if (accuracy >= settings.scoring.threeStars) return 3;
    if (accuracy >= settings.scoring.twoStars) return 2;
    if (accuracy >= settings.scoring.oneStar) return 1;
    return 0;
}

// ========================================
// CLEAR CANVAS
// ========================================
function clearCanvas() {
    tracingCtx.clearRect(0, 0, tracingCanvas.width, tracingCanvas.height);
    gameState.tracedPoints = [];
    gameState.currentStrokeProgress = 0;
    gameState.totalPoints = 0;
    gameState.correctPoints = 0;
    gameState.circleClicked = false;
    updateProgress();
}

// ========================================
// NAVIGATION FUNCTIONS
// ========================================
function loadPreviousLetter() {
    if (currentHurufIndex > 0) {
        loadGame(currentHurufIndex - 1);
    }
}

function loadNextLetter() {
    if (currentHurufIndex < allHijaiyahData.length - 1) {
        hideSuccessScreen();
        loadGame(currentHurufIndex + 1);
    }
}

function restartCurrentLetter() {
    hideSuccessScreen();
    loadGame(currentHurufIndex);
}

function updateNavigationButtons() {
    const prevBtn = document.getElementById('prev-button');
    const nextBtn = document.getElementById('next-button');

    if (currentHurufIndex === 0) {
        prevBtn.disabled = true;
        prevBtn.style.opacity = '0.5';
    } else {
        prevBtn.disabled = false;
        prevBtn.style.opacity = '1';
    }

    if (currentHurufIndex === allHijaiyahData.length - 1) {
        nextBtn.disabled = true;
        nextBtn.style.opacity = '0.5';
    } else {
        nextBtn.disabled = false;
        nextBtn.style.opacity = '1';
    }
}

// ========================================
// SUCCESS SCREEN
// ========================================
function showSuccessScreen() {
    // 1. Hitung Akurasi/Skor Global
    let overallAccuracy = 0;

    if (gameState.totalGamePoints > 0) {
        overallAccuracy = Math.round((gameState.totalGameCorrectPoints / gameState.totalGamePoints) * 100);
    } else {
         // Jika tidak ada poin (misal semua stroke adalah circle), set 100% jika semua stroke selesai
         if (allHijaiyahData[currentHurufIndex].strokes.length === gameState.completedStrokes.length) {
             overallAccuracy = 100;
         }
    }

    // 2. Set Global Variables (agar bisa diakses oleh saveTracingScore)
    window.gameFinalScore = overallAccuracy; // Menggunakan Akurasi sebagai skor yang disimpan
    window.gameAccuracyPercentage = overallAccuracy;

    const modal = document.getElementById('success-modal');
    const backButton = document.getElementById('back-to-menu-button');
    const saveStatusElement = document.getElementById('save-status');
    const nextLetterButton = document.getElementById('next-letter-button'); 
    const tryAgainButton = document.getElementById('try-again-button'); 
    const finalStars = document.getElementById('final-stars');
    const finalAccuracyDisplay = document.getElementById('final-accuracy');
    const finalScore = document.getElementById('final-score');
    const successMessage = document.getElementById('success-message');

    const stars = getStars(gameState.currentStrokeAccuracy);
    finalStars.innerHTML = '⭐'.repeat(stars) + '☆'.repeat(3 - stars);
    finalScore.textContent = `Akurasi: ${overallAccuracy}%`;

    if (stars === 3) {
        successMessage.textContent = 'Sempurna! Kamu menulis huruf dengan sangat baik!';
    } else if (stars === 2) {
        successMessage.textContent = 'Bagus! Terus berlatih untuk hasil yang lebih baik!';
    } else if (stars === 1) {
        successMessage.textContent = 'Cukup baik! Coba lagi untuk meningkatkan akurasi!';
    } else {
        successMessage.textContent = 'Terus berlatih! Kamu pasti bisa lebih baik!';
    }

    // Reset status tampilan save
    if (saveStatusElement) {
        saveStatusElement.innerText = 'Menyimpan skor...';
        saveStatusElement.classList.remove('text-green-600', 'text-red-600');
        saveStatusElement.classList.add('text-yellow-600');
    }
    if (backButton) {
        backButton.disabled = true; // Nonaktifkan tombol Kembali saat proses save
    }    

    modal.style.display = 'flex';

    saveStatusElement.innerText = 'Menyimpan skor...';
    saveStatusElement.classList.add('text-yellow-600');
    backButton.disabled = true;
    nextLetterButton.disabled = true; 
    tryAgainButton.disabled = true; 
    
    saveTracingScore().then(() => {
        // SUKSES: Aktifkan tombol navigasi setelah skor terkirim
        saveStatusElement.innerText = `Skor ${window.gameFinalScore}% berhasil disimpan!`;
        saveStatusElement.classList.remove('text-yellow-600');
        saveStatusElement.classList.add('text-green-600');
        backButton.disabled = false;
        nextLetterButton.disabled = false;
        tryAgainButton.disabled = false; 
    }).catch(error => {
        // GAGAL
        saveStatusElement.innerText = `Gagal menyimpan skor. Coba Lagi!`;
        saveStatusElement.classList.remove('text-yellow-600');
        saveStatusElement.classList.add('text-red-600');
        backButton.disabled = false;
        tryAgainButton.disabled = false; // Boleh ulang walau skor gagal dikirim
    });

}

function hideSuccessScreen() {
    const modal = document.getElementById('success-modal');
    modal.style.display = 'none';
}

// ========================================
// SUBMIT SCORE TO SERVER
// ========================================

function calculateAccuracy(strokesDone, totalStrokes) {
    return Math.round((strokesDone / totalStrokes) * 100);
}

// Tambahkan fungsi ini di dalam script di tracing.blade.php atau di public/js/game-tracing.js

// --- 1. AMBIL DATA SUNTIKAN ---
// Kalau gak ada suntikan (misal test lokal), pakai default null/array kosong
const jenisGameId = (typeof JENIS_GAME_ID !== 'undefined') ? JENIS_GAME_ID : null;
const tingkatanId = (typeof TINGKATAN_ID !== 'undefined') ? TINGKATAN_ID : null;
const saveScoreUrl = (typeof SAVE_SCORE_URL !== 'undefined') ? SAVE_SCORE_URL : '/game/save-score';
const redirectUrl = (typeof REDIRECT_URL !== 'undefined') ? REDIRECT_URL : '/';

// ... (Kode inisialisasi game, variabel gameState, dll TETAP SAMA) ...


// --- 2. UPDATE FUNGSI SAVE SCORE ---
async function saveTracingScore() {
    // Ambil skor dari variabel global window yang di-set saat showSuccessScreen
    const skor = window.gameFinalScore || 0; 
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const saveStatusElement = document.getElementById('save-status');
    const backButton = document.getElementById('back-to-menu-button');

    // Update UI
    if (saveStatusElement) {
        saveStatusElement.innerText = 'Menyimpan skor...';
        saveStatusElement.classList.remove('text-green-600', 'text-red-600');
        saveStatusElement.classList.add('text-yellow-600');
    }
    if (backButton) backButton.disabled = true;

    try {
        // Fetch ke URL yang benar
        const response = await fetch('/murid/game/save-score', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({
                jenis_game_id: jenisGameId,
                // Hapus game_static_id
                skor: skor,        // Skor akurasi (0-100)
                total_poin: skor   // Total poin sama dengan skor akurasi
            })
        });

        const data = await response.json();

        if (data.success) {
            if (saveStatusElement) {
                saveStatusElement.innerText = `Skor ${skor}% berhasil disimpan!`;
                saveStatusElement.classList.remove('text-yellow-600');
                saveStatusElement.classList.add('text-green-600');
            }
            // Redirect setelah sukses (opsional, atau biarkan user klik tombol kembali)
            // window.location.href = redirectUrl; 
        } else {
            throw new Error('Gagal menyimpan data.');
        }
    } catch (error) {
        console.error('Error:', error);
        if (saveStatusElement) {
            saveStatusElement.innerText = 'Gagal menyimpan skor.';
            saveStatusElement.classList.remove('text-yellow-600');
            saveStatusElement.classList.add('text-red-600');
        }
    } finally {
        if (backButton) backButton.disabled = false;
    }
}