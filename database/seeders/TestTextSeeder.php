<?php

namespace Database\Seeders;

use App\Models\TestText;
use Illuminate\Database\Seeder;

class TestTextSeeder extends Seeder
{
    public function run(): void
    {
        $texts = [
            'en' => [
                [
                    'genre' => 'fiction',
                    'text' => 'In the year 2247, humanity had colonized the stars, but the frontier planet of Xerion was unlike any other. Its crimson skies shimmered with electromagnetic storms, and the native flora pulsed with bioluminescent energy. Captain Elena Voss led her crew through the dense jungle, their suits humming with protective shields. The mission was simple: retrieve the lost artifact said to control time itself. But as they ventured deeper, the jungle seemed to whisper, bending their perception of reality. Shadows moved unnaturally, and the air grew heavy with an unspoken warning. Would they find the artifact, or become lost in Xerion\'s endless maze?',
                ],
                [
                    'genre' => 'fiction',
                    'text' => 'The old house on Willow Lane stood silent under the weight of a hundred winters, its warped wooden beams groaning softly in the night. Paint peeled from the walls like dead skin, curling into brittle flakes that drifted to the warped porch below. Nobody had lived there since the summer of 1962, when the last of the Harrow family vanished without a trace. The townsfolk of Eldridge whispered stories about that night-stories of strange lights flickering in the attic, of screams that weren\'t quite human, of shadows that moved against the moonlight without a source. Kids dared each other to knock on the door, but none ever stepped inside. Not until Lila.',
                ],
                [
                    'genre' => 'fiction',
                    'text' => 'Lila was sixteen, with a streak of defiance that burned brighter than her common sense. She\'d grown up on the edge of Eldridge, in a trailer park where the air always smelled of diesel and regret. Her mother worked double shifts at the diner, leaving Lila to fend for herself most nights. Maybe that\'s why she was drawn to the house. It wasn\'t just the thrill of a dare; it was the promise of something else, something bigger than the small, suffocating life she knew. So, on a chilly October evening, with a half-moon hanging low in the sky, she slipped through the rusted gate and approached the front door.',
                ],
                [
                    'genre' => 'fiction',
                    'text' => 'The air was thick with the scent of damp earth and rotting wood. Her sneakers crunched against the gravel path, each step louder than the last. The door was ajar, just a crack, as if inviting her in. She pushed it open, and the hinges screamed, a sound that made her heart lurch. Inside, the house was a tomb of shadows. Dust hung in the air, catching the faint glow of her flashlight. The wallpaper was faded, floral patterns bleeding into stains of mildew. A staircase spiraled upward into darkness, its banister splintered and sagging.',
                ],
                [
                    'genre' => 'fiction',
                    'text' => 'Lila\'s breath caught as she stepped over the threshold. The floorboards creaked beneath her weight, and for a moment, she swore she heard a whisper-a soft, unintelligible murmur that seemed to come from the walls themselves. She shook it off, telling herself it was just the wind. Her flashlight swept the room, revealing a parlor frozen in time: a moth-eaten sofa, a cracked mirror, a grandfather clock with its hands stuck at midnight. On the mantel sat a single photograph, its edges curled with age. She picked it up, wiping away decades of grime. The image showed a family-two parents, a boy, and a girl-smiling stiffly in black-and-white. The Harrows, she assumed. Their eyes seemed to follow her, even as she set the photo down.',
                ],
                [
                    'genre' => 'fiction',
                    'text' => 'Upstairs, the air grew colder. Lila\'s flashlight flickered, casting jagged shadows across the hallway. Doors lined the walls, most of them shut tight. She tried one, but it wouldn\'t budge, as if sealed by some unseen force. Another door, at the far end, was slightly open, and a faint glow spilled from within. Her pulse quickened. She didn\'t believe in ghosts, not really, but the stories she\'d heard her whole life gnawed at her resolve. Still, she moved forward, driven by a curiosity that felt almost compulsive.',
                ],
                [
                    'genre' => 'fiction',
                    'text' => 'The room was small, its walls papered in a faded blue. A child\'s bed sat in the corner, its mattress sagging under the weight of time. Toys were scattered across the floor: a wooden horse, a porcelain doll with one eye missing, a tin soldier frozen in mid-march. In the center of the room was a music box, its lid open, playing a soft, eerie melody that shouldn\'t have been possible after all these years. Lila knelt beside it, her fingers trembling as she reached out. The moment she touched it, the music stopped. Silence pressed against her ears, heavy and unnatural.',
                ],
                [
                    'genre' => 'fiction',
                    'text' => 'Scrambling to her feet, Lila lunged for the door. It slammed shut before she could reach it. She yanked at the handle, but it wouldn\'t move. Behind her, the grandfather clock began to chime, each toll shaking the house like a heartbeat. The air grew colder, the shadows thicker. And then she saw her. The girl from the photograph, standing at the top of the stairs. Her dress was tattered, her face pale as bone, her eyes two black voids that swallowed the light. She smiled, and her mouth stretched too wide, revealing teeth that glinted like shards of glass.',
                ],
                [
                    'genre' => 'fiction',
                    'text' => 'The next morning, Lila told no one what happened. The townsfolk would call her crazy, and her mother wouldn\'t care enough to listen. But she never went near the house again. She avoided Willow Lane entirely, taking the long way to school, to the diner, to anywhere. Sometimes, late at night, she\'d wake to the sound of that music box, its melody faint but unmistakable. She\'d check her windows, her doors, always locked. And yet, on her dresser, she\'d find things that shouldn\'t be there: a wooden horse, a tin soldier, a porcelain doll with one eye missing.',
                ],
                [
                    'genre' => 'fiction',
                    'text' => 'Eldridge never changed. The house still stood, its windows dark, its door slightly ajar. Kids still dared each other to knock, but none ever stepped inside. Lila left town the day she turned eighteen, hitchhiking to anywhere but there. She never spoke of that night, not to friends, not to lovers, not to the therapist she saw for a year in her twenties. But she kept the photograph she\'d taken from the house, hidden in a box under her bed. Sometimes, when she was alone, she\'d pull it out and stare at the Harrows, their stiff smiles, their hollow eyes. And every time, she\'d notice something new: a shadow in the background, a smudge where the girl once stood, or her own face, faintly reflected in the glass, smiling back.',
                ],
                [
                    'genre' => 'non-fiction',
                    'text' => 'Renewable energy has become a cornerstone of modern efforts to combat climate change. Unlike fossil fuels, which release harmful greenhouse gases, renewable sources like solar, wind, and hydropower produce clean energy with minimal environmental impact. Solar panels capture sunlight and convert it into electricity, while wind turbines harness the power of air currents. Hydropower, one of the oldest renewable sources, uses flowing water to generate energy. These technologies are not only sustainable but also increasingly cost-effective, as advancements have reduced production and installation costs. Governments worldwide are investing heavily in renewable infrastructure, recognizing the dual benefits of environmental protection and economic growth. For instance, countries like Germany and Denmark have set ambitious targets to transition to 100% renewable energy by 2050. However, challenges remain, including the intermittency of sources like solar and wind, which depend on weather conditions. Battery storage technology is evolving to address this, storing excess energy for use when production is low. Public awareness is also critical, as individual actions-like reducing energy consumption or supporting green policies-can amplify the impact of large-scale initiatives. Transitioning to renewables is not just a technological shift but a societal one, requiring collaboration across sectors. By prioritizing sustainable energy, humanity can mitigate the worst effects of climate change and build a resilient future.',
                ],
                [
                    'genre' => 'non-fiction',
                    'text' => 'Artificial intelligence (AI) has transformed from a niche concept to a ubiquitous force shaping industries and daily life. Early AI systems, developed in the mid-20th century, were limited to basic problem-solving tasks. Today, AI powers everything from voice assistants to autonomous vehicles. Machine learning, a subset of AI, allows systems to learn from data and improve over time without explicit programming. This has led to breakthroughs in fields like healthcare, where AI can analyze medical images to detect diseases with high accuracy. In business, AI optimizes supply chains and personalizes customer experiences. However, the rapid rise of AI raises ethical concerns, including bias in algorithms and job displacement. For example, facial recognition systems have been criticized for misidentifying individuals from certain demographic groups, highlighting the need for diverse datasets. Additionally, automation threatens roles in industries like manufacturing and customer service, prompting calls for reskilling programs. Governments and organizations are grappling with how to regulate AI to balance innovation and accountability. Public discourse on AI often oscillates between excitement and fear, with some envisioning a utopian future and others warning of dystopian risks. As AI continues to evolve, its responsible development will depend on collaboration between technologists, policymakers, and society at large.',
                ],
                [
                    'genre' => 'non-fiction',
                    'text' => 'Sleep is a fundamental biological process, yet its importance is often overlooked in modern society. During sleep, the body undergoes critical functions, including tissue repair, memory consolidation, and hormone regulation. The brain processes information from the day, strengthening neural connections that support learning and problem-solving. Adults typically need 7-9 hours of sleep per night, but many fall short due to work, stress, or screen time. Chronic sleep deprivation is linked to health issues like obesity, diabetes, and cardiovascular disease. It also impairs cognitive performance, reducing focus and decision-making ability. The science of sleep has revealed distinct stages, including rapid eye movement (REM) and non-REM sleep, each serving unique purposes. REM sleep, associated with vivid dreams, supports emotional regulation, while non-REM sleep aids physical recovery. External factors, like blue light from devices, can disrupt the production of melatonin, a hormone that signals sleep readiness. To improve sleep quality, experts recommend consistent schedules, dark environments, and limiting caffeine. Cultural attitudes toward sleep are shifting as research highlights its role in productivity and well-being. Employers are beginning to recognize that well-rested workers are more effective, prompting policies like flexible hours. Prioritizing sleep is not a luxury but a necessity for health and performance.',
                ],
                [
                    'genre' => 'non-fiction',
                    'text' => 'Urban farming is reshaping how cities approach food production, addressing issues like food security and sustainability. Unlike traditional agriculture, urban farms operate in densely populated areas, utilizing rooftops, vacant lots, and vertical gardens. These farms grow fresh produce, reducing reliance on long-distance supply chains that contribute to carbon emissions. Community gardens, a form of urban farming, foster social cohesion by bringing residents together to cultivate shared spaces. Hydroponics and aquaponics, innovative farming techniques, allow year-round production with minimal water and no soil. Urban farming also supports local economies by creating jobs and supplying restaurants with fresh ingredients. However, challenges like high startup costs and limited space can hinder scalability. In response, cities like Tokyo and New York are offering subsidies and zoning changes to encourage urban agriculture. Beyond practical benefits, urban farms reconnect people with nature, countering the alienation often felt in concrete-heavy environments. Educational programs tied to these farms teach children and adults about nutrition and environmental stewardship. As urban populations grow, farming in cities offers a viable solution to feed communities sustainably while promoting resilience against climate disruptions. The movement reflects a broader shift toward localized, eco-conscious living.',
                ],
                [
                    'genre' => 'non-fiction',
                    'text' => 'Social media platforms have revolutionized communication, but their impact on mental health is a growing concern. These platforms enable instant connection, allowing users to share experiences and build communities. However, excessive use is linked to anxiety, depression, and low self-esteem, particularly among adolescents. The pressure to curate perfect online personas can lead to unrealistic comparisons, exacerbated by algorithms that prioritize engaging content. Cyberbullying, another issue, thrives in the anonymity of digital spaces, causing emotional harm. Studies show that prolonged screen time disrupts sleep, as notifications and scrolling keep users engaged late into the night. On the positive side, social media can provide support networks for marginalized groups and raise awareness about mental health issues. To mitigate negative effects, experts suggest setting time limits, curating feeds to reduce toxic content, and taking regular digital detoxes. Platforms are also introducing features like usage trackers and content warnings to promote healthier habits. Parents and educators play a role in teaching young users to navigate social media critically. As society grapples with its digital dependency, balancing connectivity with well-being remains a priority. Social media\'s influence is undeniable, but its impact depends on how it\'s used.',
                ],
                [
                    'genre' => 'non-fiction',
                    'text' => 'Regular exercise is one of the most effective ways to enhance longevity and quality of life. Physical activity strengthens the cardiovascular system, reducing the risk of heart disease, stroke, and hypertension. It also boosts mental health by releasing endorphins, which alleviate stress and improve mood. Strength training, in particular, preserves muscle mass and bone density, countering age-related decline. Even moderate activities like walking or yoga can improve flexibility and balance, reducing the risk of falls in older adults. Exercise also supports metabolic health, helping regulate blood sugar and prevent diabetes. The World Health Organization recommends at least 150 minutes of moderate aerobic activity per week, yet many struggle to meet this goal due to sedentary lifestyles. Workplace wellness programs and fitness apps are making exercise more accessible, offering guided routines and tracking tools. Social factors, like group classes or sports, can increase motivation by fostering community. While the benefits are clear, barriers like time constraints or lack of access to facilities persist, particularly in underserved areas. Public health campaigns aim to address these by promoting active transportation, like cycling, and creating green spaces. Incorporating exercise into daily routines is a powerful step toward a longer, healthier life.',
                ],
                [
                    'genre' => 'non-fiction',
                    'text' => 'Space exploration has captivated humanity for decades, driven by curiosity and the quest for knowledge. The Space Race of the 20th century, fueled by Cold War rivalry, led to milestones like the 1969 Apollo 11 moon landing. Since then, advancements have expanded our understanding of the cosmos. Robotic probes, like Voyager and Mars rovers, have explored distant planets, revealing insights about their geology and potential for life. The International Space Station, a collaborative effort, serves as a hub for scientific research in microgravity. Private companies, such as SpaceX, are now revolutionizing the industry by developing reusable rockets and planning missions to Mars. Space exploration has practical benefits, including satellite technology that enables global communication and weather forecasting. However, it faces challenges, such as high costs and the ethical question of prioritizing space over earthly needs. Environmental concerns also arise, as space debris threatens satellites and future missions. Public enthusiasm remains strong, with events like telescope launches inspiring awe. As technology progresses, ambitions grow, from establishing lunar bases to searching for extraterrestrial life. Space exploration reflects humanity\'s drive to push boundaries, offering both scientific breakthroughs and a reminder of our place in the universe.',
                ],
                [
                    'genre' => 'non-fiction',
                    'text' => 'Lifelong learning is the practice of continuously acquiring knowledge and skills throughout one\'s life. In a rapidly changing world, it\'s essential for personal and professional growth. Technological advancements and automation are reshaping industries, making adaptability a critical asset. Online platforms like Coursera and Khan Academy have democratized education, offering courses on topics from coding to philosophy. Lifelong learning also enhances cognitive health, as engaging the brain through reading or problem-solving can delay age-related decline. Beyond career benefits, it fosters curiosity and self-confidence, enriching lives through new hobbies or cultural exploration. Communities benefit too, as informed citizens contribute to civic discourse. However, barriers like time, cost, and access can limit participation, particularly for low-income individuals. Governments and organizations are addressing this through free programs and workplace training. Motivation is another hurdle, as adults often juggle learning with responsibilities. Setting clear goals and integrating learning into daily routines-like listening to podcasts-can help. The rise of micro-credentials, short courses that certify specific skills, reflects the demand for flexible education. Lifelong learning is not just about staying relevant; it\'s about embracing growth and finding joy in discovery, regardless of age or circumstance.',
                ],
                [
                    'genre' => 'non-fiction',
                    'text' => 'Global food security remains a pressing issue as the world\'s population approaches 10 billion by 2050. Food security means consistent access to nutritious, affordable food, yet millions face hunger due to poverty, conflict, and climate change. Droughts and extreme weather disrupt harvests, while soil degradation reduces arable land. In developing nations, small-scale farmers often lack resources like modern equipment or seeds, limiting productivity. Global trade can stabilize supply but is vulnerable to disruptions, as seen during pandemics or geopolitical tensions. Biotechnology, such as genetically modified crops, offers solutions by increasing yields and resistance to pests, but it faces public skepticism. Food waste is another challenge, with nearly a third of produced food discarded, often due to cosmetic standards or poor storage. Initiatives like urban farming and vertical agriculture aim to boost local production, while policies promoting sustainable practices encourage resilience. Education plays a role, as teaching communities about nutrition and farming techniques empowers self-sufficiency. International cooperation is vital, as no single nation can address food security alone. Organizations like the United Nations work to coordinate aid and innovation. Ensuring food security requires tackling systemic inequalities, embracing technology, and fostering global solidarity to create a hunger-free future.',
                ],
                [
                    'genre' => 'non-fiction',
                    'text' => 'The future of work is being reshaped by digital technologies, automation, and shifting societal values. Remote work, accelerated by the pandemic, has become a staple, enabled by tools like video conferencing and cloud computing. This flexibility enhances work-life balance but blurs boundaries, leading to burnout for some. Automation, including robotics and AI, is transforming industries, streamlining tasks but displacing low-skill jobs. Meanwhile, demand for skills in data analysis, cybersecurity, and software development is soaring. The gig economy, powered by platforms like Uber, offers flexibility but lacks job security or benefits, sparking debates over worker rights. Companies are prioritizing employee well-being, with policies like mental health support and flexible hours. Diversity and inclusion are also gaining focus, as varied perspectives drive innovation. However, challenges persist, including the digital divide, which limits access to technology in rural or low-income areas. Upskilling programs are critical to prepare workers for new roles, yet funding and accessibility vary. The future of work will likely blend human creativity with machine efficiency, requiring adaptability and lifelong learning. As organizations and governments navigate these changes, collaboration will be key to ensuring an inclusive, equitable workplace that benefits all.',
                ],
                [
                    'genre' => 'poetry',
                    'text' => <<<EOT
In the hush of dawn, where shadows softly creep,
The world awakens from its tender sleep.
The sky, a canvas painted with pastel hues,
Blushes pink, then gold, as morning's muse
Unfurls her light across the sleepy glade.
The whispering breeze, through ancient oaks, does wade,
And carries secrets only trees can know,
Their roots entwined where quiet rivers flow.
Each leaf a stanza, trembling in the air,
A fleeting poem, delicate and fair.
The sparrow sings, a melody so slight,
Yet pierces through the remnants of the night.
Its notes, like petals, drift on winds unseen,
To weave a song where silence once had been.
The meadow hums with life, a subtle choir,
Of crickets, bees, and grasses that aspire
To touch the heavens with their verdant prayer,
A hymn of green, ascending through the air.
The poet's heart, attuned to nature's rhyme,
Finds solace in the rhythm of the time.
Each blade of grass, each dewdrop's fragile sphere,
Reflects a truth that only dawn makes clear:
That beauty lies in moments brief and small,
In fleeting glances where the heart does call.
The sun ascends, its warmth a gentle hand,
Caressing earth, embracing sea and land.
The shadows shrink, their mysteries retreat,
Yet leave behind a warmth, a lingering heat.
And in this light, the poet takes her pen,
To capture dawn before it fades again.
The words, like rivers, carve their winding course,
Through valleys deep, with unrelenting force.
They spill like rain upon the barren page,
A torrent born of joy, of love, of rage.
For poetry is breath, is blood, is fire,
A spark of soul that never will expire.
It dances wild beneath the starlit skies,
And mourns the loss where broken beauty lies.
The moon, a sentinel of silver gleam,
Illuminates the poet's fevered dream.
Its crescent curves, a cradle for the night,
Where thoughts take wing and soar in boundless flight.
The stars, like lanterns, flicker in their place,
Each one a story, etched in cosmic space.
The poet weaves their light into her verse,
A tapestry of wonder, vast, diverse.
The night is hers, a realm of endless scope,
Where shadows blend with dreams, and dreams with hope.
Yet dawn returns, relentless in its tread,
To paint the world in amber, gold, and red.
The cycle spins, unyielding, yet so kind,
A rhythm etched within the poet's mind.
For every verse, a moment caught in time,
A fleeting truth, immortalized in rhyme.
The heart beats on, its cadence soft and sure,
A drum that echoes, steadfast and secure.
And poetry, the language of the soul,
Binds fleeting fragments into something whole.
Through ages past, through futures yet to come,
The poet's voice will never be struck dumb.
It rises still, through sorrow and through glee,
A testament to what it means to be.
So let the words cascade, like rivers free,
And carve their path to vast eternity.
EOT,
                ],
                [
                    'genre' => 'poetry',
                    'text' => <<<EOT
The ocean whispers secrets to the shore,
Its waves a tale of what has gone before.
Each crest, each trough, a chapter in the deep,
Where ancient ghosts and sunken treasures sleep.
The foam, like lace, adorns the sandy bed,
A fleeting crown where sea and earth are wed.
The gulls above, with wings that slice the breeze,
Cry out their hymns to distant, unseen seas.
Their voices blend with salt and wind and spray,
A chorus wild, that carries far away.
The poet stands, her feet upon the strand,
Her heart a vessel, anchored to the land.
Yet in her soul, the ocean's call is strong,
Its endless song, both lullaby and wrong.
For who can know the depths that lie below,
Where currents twist and shadowy creatures go?
The poet dares to dream, to dive, to seek,
To find the words where mortal tongues grow weak.
Her verses surge, like tides that rise and fall,
And echo truths that resonate through all.
The sea is vast, its mysteries profound,
A realm where even gods have sometimes drowned.
Yet still it calls, with beauty and with dread,
To weave its tale within the poet's head.
The stars reflect upon the water's face,
A mirror held to heavens' boundless grace.
Each ripple holds a fragment of the sky,
A fleeting glimpse of worlds that soar on high.
The poet writes, her ink as dark as night,
Yet filled with sparks of celestial light.
Her words are waves that crash, then softly fade,
A dance of dreams upon the shore remade.
The ocean knows no master, bows to none,
Its will enduring when all else is done.
And yet it yields its stories to the pen,
To be reborn in hearts of mortal men.
So let the poet sing, her voice a tide,
That carries hope where broken dreams reside.
For in her lines, the sea will ever dwell,
A timeless song, too vast for tongue to tell.
EOT,
                ],
                [
                    'genre' => 'poetry',
                    'text' => <<<EOT
The forest hums beneath a velvet sky,
Where ancient trees reach up, and spirits fly.
Their branches weave a canopy of dreams,
Where moonlight spills in soft, ethereal streams.
The owl, with eyes like embers, softly calls,
Its voice a thread that echoes through the halls
Of shadowed glades, where secrets gently lie,
Enfolded in the earth's eternal sigh.
The poet treads, her steps a reverent prayer,
Each breath a verse, each moment rare.
The moss beneath her feet, a velvet scroll,
Records the tales that only forests hold.
The wind, a bard, recites its ancient lore,
Of heroes lost, of loves that came before.
The leaves, like pages, flutter in the breeze,
Their whispers blending with the midnight seas.
The poet kneels, her heart an open book,
To drink the wisdom of the winding brook.
Its waters sing of journeys yet to come,
Of paths untrod, of battles yet unwon.
The forest knows the weight of time's embrace,
Its roots a map of every human face.
And in its shade, the poet finds her voice,
A spark of truth, a solitary choice.
To speak of love, of loss, of fleeting joy,
Of moments bright that time will soon destroy.
Her words take root, like seeds beneath the earth,
And promise life, and promise gentle birth.
The stars above, through branches, softly peer,
Their light a guide, both distant and sincere.
The poet weaves their glow into her rhyme,
A bridge that spans the boundaries of time.
For poetry is more than ink and page,
It is the soul's release from mortal cage.
It dances free, where wild things roam and sing,
And binds the heart to every living thing.
So let the forest's song forever sound,
In verses deep, where truth is ever found.
EOT,
                ],
                [
                    'genre' => 'poetry',
                    'text' => <<<EOT
The city pulses, vibrant, fierce, alive,
Its neon heart where dreams and shadows thrive.
The streets, like arteries, bear ceaseless flow,
Of lives that clash, that merge, that come and go.
The poet walks, her eyes a burning flame,
To catch the spark of every fleeting name.
Each face a story, etched in joy or pain,
Each step a verse in life's unending chain.
The horns, the cries, the laughter, and the din,
Compose a symphony that pulls her in.
She writes of towers reaching for the stars,
Of broken hearts and dreams behind the bars.
The city's breath, a mix of smoke and fire,
Ignites her soul, her words a funeral pyre
For moments lost, for hopes that fade too fast,
Yet rise again, unshackled from the past.
The poet sings of markets, bright and loud,
Of quiet alleys, hidden from the crowd.
Of children's laughter, ringing through the night,
Of lovers' whispers, bathed in sodium light.
The city holds her, fierce, yet tender too,
Its contradictions mirrored in her view.
Her verses carve a space where all belong,
A fragile peace within the urban song.
The dawn arrives, its light a gentle blade,
To cut the dark where memories are made.
The poet writes, her heart a steady drum,
To greet the day, and all that is to come.
For in the city, poetry is breath,
A shield against the specter of our death.
It binds the soul to every fleeting spark,
And lights the way through chaos and the dark.
EOT,
                ],
                [
                    'genre' => 'poetry',
                    'text' => <<<EOT
The mountain stands, unyielding, stark, and grand,
Its peaks a challenge to the mortal hand.
The poet climbs, her heart a beating flame,
To etch its might within her fragile frame.
Each step a verse, each breath a sacred vow,
To capture truth that only heights allow.
The wind howls fierce, a chorus of the wild,
Yet in its roar, the poet finds a child.
A spark of wonder, buried deep within,
That calls her on, through tempest and through din.
The summit gleams, a beacon in the mist,
A fleeting goal that only dreams enlist.
The poet writes, her words a rugged stone,
Each one a piece of mountains she has known.
The valleys far below, in shadow cast,
Hold echoes of a distant, tender past.
Yet here, above, where earth and heavens meet,
The poet finds her purpose, pure, complete.
Her verses soar, like eagles on the breeze,
And carve a path through time's unyielding frieze.
The mountain knows the weight of countless years,
Its silence born of triumphs and of tears.
And in its gaze, the poet sees her place,
A fleeting spark within the vast embrace.
So let her sing, her voice a timeless call,
To rise, to strive, to conquer, and to fall.
For poetry is more than fleeting sound,
It is the soul's own mountain, ever found.
EOT,
                ],
                [
                    'genre' => 'poetry',
                    'text' => <<<EOT
Beneath the canopy of starlit skies,
Where shadows dance and midnight sighs,
The wanderer treads with quiet grace,
His heart a map to some lost place.
The wind, a bard with tales to tell,
Recites of heavens, sings of hell.
Its whispers curl through ancient trees,
Their branches swaying in the breeze.
Each leaf a page, each root a rhyme,
Preserving secrets lost to time.
The moon ascends, a silver crown,
Its glow upon the world cast down.
It lights the path where dreams abide,
Where hopes and fears walk side by side.
The wanderer's boots, with dust endowed,
Trace roads where stars and earth are vowed.
His cloak, a shroud of twilight's hue,
Bears stains of rains he's journeyed through.
Each step a vow, each breath a prayer,
To find the truth that lingers there.
The river hums, its waters clear,
Reflecting stars that hover near.
Its current weaves a tale of old,
Of lovers lost, of hearts grown cold.
The wanderer kneels upon its bank,
His soul athirst, his spirit sank.
He cups the stream in trembling hands,
And drinks of time's unyielding sands.
EOT,
                ],
                [
                    'genre' => 'poetry',
                    'text' => <<<EOT
The ripples sing of days long past,
Of fleeting joys that could not last.
Through meadows green, through valleys deep,
Where wildflowers in silence sleep,
He walks where sunlight dares not stray,
And shadows hold their gentle sway.
The lark above, with wings of fire,
Sings hymns that lift the heart's desire.
Its melody, a fragile thread,
Binds life to dreams where hope has fled.
The wanderer pauses, eyes alight,
To weave that song into the night.
The mountains loom, their peaks severe,
A challenge born of primal fear.
Their crags, like sentinels, stand tall,
And echo back the wanderer's call.
He climbs where eagles dare to soar,
Where tempests rage and thunder roar.
Each foothold carved by wind and time,
Each summit reached, a sacred rhyme.
The air grows thin, the heart grows bold,
To touch the stars, so bright, so cold.
At twilight's edge, where worlds converge,
He stands to sing his soul's own dirge.
The horizon burns with amber flame,
And whispers soft his secret name.
The wanderer's voice, though worn and low,
Resounds where wildest rivers flow.
EOT,
                ],
                [
                    'genre' => 'poetry',
                    'text' => <<<EOT
His words, like embers, rise and fall,
A fleeting spark to pierce the pall.
They carry dreams of distant lands,
And trace the lines of weathered hands.
The forest whispers, dark and deep,
Its secrets guarded while we sleep.
The oak, the pine, the willow's grace,
Entwine to form a sacred space.
The wanderer rests beneath their shade,
His heart by starlight gently swayed.
The moss, a cradle, soft and green,
Preserves the truths his eyes have seen.
Each breath he draws, a solemn vow,
To honor then, to cherish now.
The city calls, its pulse alive,
Where neon dreams and shadows thrive.
Its streets, like veins, bear ceaseless flow,
Of lives that clash, that come, that go.
The wanderer walks its crowded ways,
His heart attuned to fleeting days.
Each face a story, etched in strife,
Each glance a glimpse of fleeting life.
He writes of towers, stark and high,
That pierce the veil of twilight's sky.
The ocean roars, its voice untamed,
Its depths by mortal tongue unclaimed.
Each wave a tale of joy and woe,
Of sunken ships where corals grow.
EOT,
                ],
                [
                    'genre' => 'poetry',
                    'text' => <<<EOT
The wanderer stands upon the shore,
His soul adrift forevermore.
The salt, the spray, the gull's wild cry,
Compose a song that cannot die.
He casts his dreams upon the tide,
And lets the sea become his guide.
Through deserts vast, where silence reigns,
And sun-scorched earth alone remains,
He walks where life is but a spark,
A fleeting glow against the dark.
The dunes, like waves, in stillness lie,
Their curves a mirror of the sky.
The wanderer's heart, though parched and worn,
Finds solace where the stars are born.
Each grain of sand, a tale untold,
Of ancient worlds, both young and old.
The seasons turn, relentless, sure,
Their cycles steadfast, yet so pure.
The spring awakens, blooms unfold,
The summer hums with sunlight's gold.
The autumn weaves its crimson thread,
The winter whispers of the dead.
The wanderer knows their endless dance,
Their rhythm born of cosmic chance.
He writes of time, of love, of loss,
Of fleeting joys that bear a cost.
Beneath the stars, his journey ends,
Where time and tide no longer bend.
EOT,
                ],
                [
                    'genre' => 'poetry',
                    'text' => <<<EOT
The wanderer rests, his heart at peace,
His soul released, his wanderings cease.
Yet in his words, his spirit lives,
A gift to all the world he gives.
Each verse a spark, each line a flame,
To light the dark and speak his name.
For poetry, like breath, like fire,
Endures beyond the heart's desire.
So sing, O wind, through ancient glades,
Where sunlight weaves its golden braids.
So hum, O river, soft and low,
And carry dreams where wild things go.
So roar, O sea, with might untamed,
And call the stars by every name.
The wanderer's verse, though he may fade,
Remains where love and truth are made.
Its cadence binds the heart to all,
From mountain's peak to ocean's call.
Let every soul who reads this rhyme,
Find courage through the tides of time.
Let every hand that types these lines,
Feel sparks where mortal hope entwines.
For poetry is more than art,
It is the pulse of every heart.
It dances free where wild things roam,
And calls the weary spirit home.
The wanderer's path, though long and far,
Leads ever to the truths we are.
EOT,
                ],
            ],
            'ru' => [
                [
                    'genre' => 'fiction',
                    'text' => 'Вечер опускался на деревню, словно старое одеяло, сотканное из сумерек и тишины. Лес, окружавший дома, шептал что-то на своем древнем языке, но никто из жителей не смел вслушиваться. Говорили, что в чаще обитает тень - не человек, не зверь, а нечто иное, чему нет имени. Анна, девушка с волосами цвета ржи, не верила в эти байки. Она сидела на крыльце, глядя на звезды, и думала о том, как выбраться из этой глуши. Ей было девятнадцать, и мир за пределами деревни казался манящим, как сказка. Анна работала в местной пекарне, где каждый день месила тесто и слушала сплетни старух. Они судачили о пропавшем охотнике, о странных следах у реки, о том, что лес стал гуще, будто растет сам по себе. Анна лишь улыбалась, пропуская их слова мимо ушей. Но той ночью, когда луна висела низко, словно лампа в заброшенном доме, она заметила движение у опушки. Тень - неясная, но живая - скользнула между деревьями. Сердце Анны забилось быстрее. Она встала, накинула шаль и, не думая, шагнула к лесу. Деревня спала, и только сова где-то вдали нарушала тишину. Тропинка, знакомая с детства, вела к реке, но в темноте она казалась чужой. Листья шуршали под ногами, а воздух пах сыростью и чем-то еще - терпким, как старое вино. Анна остановилась, вглядываясь в мрак. Тень появилась снова, на этот раз ближе. Она не двигалась, но Анна чувствовала ее взгляд, тяжелый, как камень.',
                ],
                [
                    'genre' => 'fiction',
                    'text' => 'Игорь стоял на перроне, сжимая в руках билет. Поезд должен был прийти с минуты на минуту, но платформа пустовала. Ни людей, ни шума - только фонарь мигал, отбрасывая длинные тени. Ветер нес запах ржавчины и мокрого асфальта. Игорь посмотрел на билет: пункт назначения не указан. Он купил его в кассе на вокзале, не задавая вопросов. Кассир, старуха с глазами, как два черных омута, лишь улыбнулась и сказала: "Этот поезд довезет тебя туда, куда нужно". Фары мелькнули вдали, и поезд, старый, с облупленной краской, подкатил к перрону. Двери открылись с тяжелым скрипом. Игорь шагнул внутрь. Вагон был пуст, но пахло табаком и чем-то сладким, как старые духи. Он сел у окна, глядя в темноту. Поезд тронулся, и пейзаж за окном слился в черную полосу. Игорь достал телефон, но экран был мертв. Часы тоже остановились. Он почувствовал, как холод пробирается под куртку. Где-то впереди, в соседнем вагоне, послышался шепот. Игорь встал, прошел по коридору. Дверь в следующий вагон была приоткрыта, и за ней он увидел тени - неясные, но человеческие. Они сидели за столом, играли в карты, смеялись. Но их лица были размыты, как на старой фотографии. Одна из теней повернулась к нему и поманила.',
                ],
                [
                    'genre' => 'fiction',
                    'text' => 'Маша пробралась в заброшенный особняк на окраине города. Ей было пятнадцать, и такие приключения были ее способом убежать от скуки. Дом скрипел, как старый корабль, а пыль танцевала в лучах фонарика. Она поднялась на второй этаж, где в комнате с ободранными обоями стояло зеркало - высокое, в резной раме. Оно выглядело слишком новым для этого места, будто кто-то оставил его вчера. Маша подошла ближе, ожидая увидеть свое отражение, но вместо этого зеркало показало незнакомую женщину. Она была старше, с усталыми глазами, и сидела за столом, перебирая письма. Маша моргнула, но картинка не исчезла. Женщина подняла голову, словно заметила Машу, и ее губы шевельнулись. Маша отшатнулась, но любопытство пересилило страх. Она коснулась стекла, и оно задрожало, как вода. На следующий день Маша вернулась. Зеркало теперь показывало мужчину в военной форме, марширующего по полю. Она начала приходить каждый день, и каждый раз зеркало открывало новую историю: ребенка, играющего в саду, старуху, вяжущую у камина, юношу, пишущего стихи. Маша заметила, что все они носили одну и ту же подвеску - серебряную, с выгравированным цветком. Такая же висела у нее на шее, подарок бабушки.',
                ],
                [
                    'genre' => 'fiction',
                    'text' => 'Дождь лил третий год подряд. Город утопал в серости, улицы блестели, как зеркала, а люди прятались под зонтами, забыв, как выглядит солнце. Артем, уличный художник, рисовал на стенах яркие картины: цветущие сады, закаты, лица смеющихся детей. Его краски были единственным, что нарушало монотонность. Он работал ночами, когда город засыпал, и никто не видел, как его рисунки оживают. Однажды Артем заметил, что его последняя картина - девушка с зонтом, окруженная цветами - исчезла со стены. Вместо нее на асфальте лежал лепесток, настоящий, пахнущий летом. Он поднял его, не веря глазам. На следующую ночь он нарисовал солнце, огромное, золотое. Утром стена была пуста, но впервые за годы дождь прекратился на несколько минут, и луч света пробился сквозь тучи. Люди начали шептаться. Они приходили к стенам, где рисовал Артем, и просили его изобразить их мечты. Он рисовал дома, птиц, звезды, и каждый раз что-то менялось: в городе появился запах хлеба, зазвучал смех, кто-то даже клялся, что видел радугу. Но Артем чувствовал, что его силы тают. Каждый рисунок забирал частичку его самого, и он начал кашлять, словно дождь поселился в его легких.',
                ],
                [
                    'genre' => 'fiction',
                    'text' => 'Мастерская старика пахла деревом и металлом. Полки ломились от часов: настенных, карманных, с кукушкой. Но Егор, часовщик, не чинил обычные механизмы. Его часы показывали не время, а судьбу. Клиенты приходили тайно, по ночам, и платили не деньгами, а историями. Последней была Лидия, женщина с усталым лицом. Она хотела исправить ошибку молодости - предательство, из-за которого потеряла семью. Егор выслушал ее, не поднимая глаз от работы. Его пальцы, сухие, как ветки, собирали новый механизм. "Часы не лгут, - сказал он. - Но их правда может быть тяжелой". Лидия кивнула. Егор закончил работу к утру и вручил ей часы - маленькие, с циферблатом, похожим на звездное небо. Стрелки двигались назад. Лидия вернулась через неделю, бледная, как полотно. "Я видела себя молодой, - шептала она. - Я изменила все, но теперь мой сын... он не родился". Егор молчал. Он знал, что часы дают выбор, но не счастье. Лидия ушла, а Егор достал свои собственные часы - единственные, которые он никогда не открывал. Их стрелки тоже шли назад, но он боялся узнать, куда они ведут.',
                ],
                [
                    'genre' => 'fiction',
                    'text' => 'Море пело каждую ночь. Никита, рыбак, слышал мелодию, когда выходил в лодке. Она была нежной, как колыбельная, но манила, как зов. Другие рыбаки смеялись, называя его мечтателем, но Никита знал: песня реальна. Он пытался рассказать жене, но она лишь качала головой, глядя на их пустой дом. У них не было детей, и море стало для Никиты вторым домом. Однажды мелодия стала громче. Никита вышел в море, несмотря на штормовое предупреждение. Волны бились о лодку, но песня вела его, как маяк. Он плыл часами, пока не увидел остров - маленький, с черными скалами, которого не было на картах. На берегу стояла фигура, закутанная в плащ. Она пела, и голос ее был тем самым, что звал Никиту. Он причалил, ступил на песок. Фигура обернулась - женщина с глазами, как морская глубина. "Ты пришел, - сказала она. - Но море не отпускает тех, кто отвечает на его зов". Никита не боялся. Он хотел знать, зачем песня выбрала его.',
                ],
                [
                    'genre' => 'fiction',
                    'text' => 'Библиотека появилась за одну ночь. Максим, студент, шел домой через парк, когда заметил здание там, где раньше была пустота. Оно было старым, с витражами и запахом пыли. Внутри тянулись бесконечные ряды полок, уходящих в темноту. Книги шептались, их страницы шелестели, будто живые. Максим взял одну - на обложке было его имя. Он открыл книгу и увидел свою жизнь: детство, ссоры с отцом, первый поцелуй. Но страницы менялись, стоило ему перевернуть их. В одной версии он становился врачом, в другой - бродягой. Максим провел в библиотеке часы, но время снаружи не двигалось. Он нашел книги о других людях: его друзьях, незнакомцах, даже о библиотекаре, которого никогда не видел. Каждая книга была чьей-то судьбой. На третий день он заметил, что библиотека меняется. Полки двигались, лестницы вели в новые залы. Он нашел книгу, которая была пустой, но страницы заполнялись, пока он смотрел. Это была его будущая жизнь, но она пугала: одиночество, потери, тьма. Максим решил, что должен найти выход.',
                ],
                [
                    'genre' => 'fiction',
                    'text' => 'Пустыня дышала жаром. Лена, путешественница, брела по барханам, сжимая флягу с последними каплями воды. Она искала древний город, о котором читала в старых книгах. Солнце жгло кожу, но Лена не сдавалась. На закате она увидела фигуру - мужчина танцевал среди песков, его движения были плавными, как ветер. Песок вокруг него вздымался, образуя миражи: оазис, город, лица людей. Лена подошла ближе. Танцор остановился, его глаза были черными, как ночь. "Танец показывает правду, - сказал он. - Что ты хочешь увидеть?" Лена попросила показать город. Он начал танцевать, и песок ожил: башни, улицы, фонтаны. Но в миражах Лена видела и себя - свои страхи, ошибки, несбывшиеся мечты. Она отшатнулась, но танцор продолжал. На следующий день он был там же. Лена вернулась, не в силах уйти. Каждый танец открывал что-то новое: ее детство, ссору с сестрой, потерянную любовь. Но миражи становились мрачнее, и Лена начала подозревать, что танцор не человек.',
                ],
                [
                    'genre' => 'fiction',
                    'text' => 'В городе все знали про дом на холме. Каждую ночь в одном из окон загорался свет, хотя дом пустовал десятилетиями. Виктор, журналист, решил выяснить правду. Он приехал в город, снял комнату в гостинице и начал расспрашивать местных. Старики шептались о призраках, дети рассказывали о странных звуках, но никто не знал ничего наверняка. Виктор поднялся к дому на закате. Здание было ветхим, с провалившейся крышей и разбитыми стеклами. Он вошел внутрь, фонарь дрожал в его руке. Пыль покрывала мебель, а воздух пах сыростью. Виктор нашел комнату, где горел свет. Лампа на столе светила мягко, но шнур был оторван. Он коснулся ее, и свет мигнул. На следующую ночь Виктор вернулся с камерой. Лампа снова горела, но теперь он услышал шаги. Он поднялся на чердак и нашел коробку с письмами. Они были написаны женщиной по имени Елена, которая жила здесь сто лет назад. Она писала о любви, о потере, о надежде. Виктор понял, что свет - это не просто лампа. Это было послание.',
                ],
                [
                    'genre' => 'fiction',
                    'text' => 'Сад был скрыт за высокой стеной. Ольга, садовница, ухаживала за ним по ночам, когда никто не видел. Это был не обычный сад: вместо цветов там росли воспоминания. Каждое растение - чья-то память, яркая или горькая. Ольга знала, как их пересаживать, чтобы изменить судьбы. Она делала это тайно, по просьбам тех, кто находил ее через слухи. Однажды к ней пришла женщина с пустыми глазами. Она просила убрать одно воспоминание - о ребенке, которого потеряла. Ольга согласилась, но предупредила: сад требует равновесия. Женщина ушла, а Ольга выкопала растение, хрупкое, с лепестками, как слезы. На его месте выросло другое, темное, с шипами. Ольга почувствовала холод. На следующий день женщина вернулась, но она была другой - холодной, равнодушной. Сад изменил не только ее память, но и душу. Ольга начала подозревать, что сад живой и имеет свои планы. Она заметила, что некоторые растения растут без ее участия, а тени в саду шепчутся, называя ее имя.',
                ],
                [
                    'genre' => 'non-fiction',
                    'text' => 'Письменность - одно из величайших изобретений человечества. Она позволила сохранять знания, передавать информацию через поколения и развивать культуру. Первые формы письменности появились около 5 тысяч лет назад в Месопотамии. Это была клинопись - система знаков, выдавливаемых на глиняных табличках. Египтяне разработали иероглифы, которые использовались для записи религиозных текстов и хроник. В Китае письменность развивалась на основе пиктограмм, которые со временем превратились в сложные иероглифы. Каждая культура создавала уникальные системы письма, отражающие её мировоззрение. С развитием алфавитов, таких как финикийский или греческий, письменность стала более доступной. Алфавиты упростили процесс записи, сделав его удобным для широкого круга людей. В Средние века пергамент и бумага заменили глину и папирус, а изобретение книгопечатания в XV веке радикально изменило распространение знаний. Сегодня мы используем цифровые технологии, но основа письменности остаётся неизменной. Она связывает нас с прошлым и помогает строить будущее. Практика слепой печати помогает освоить современные инструменты письма, делая процесс быстрым и эффективным. Регулярные тренировки развивают моторику и концентрацию, позволяя печатать, не отвлекаясь на клавиатуру. Это умение полезно для всех, кто работает с текстами.',
                ],
                [
                    'genre' => 'non-fiction',
                    'text' => 'Человеческий мозг - сложнейший орган, управляющий всеми функциями тела и разума. Он состоит из миллиардов нейронов, соединённых синапсами, которые передают электрические импульсы. Мозг делится на несколько зон, каждая из которых отвечает за определённые функции. Например, лобные доли контролируют мышление и принятие решений, а затылочные - зрение. Интересно, что мозг потребляет около 20% энергии тела, хотя весит всего 2% от общей массы. Учёные до сих пор изучают, как мозг обрабатывает информацию. Память, эмоции, творчество - всё это результат сложных нейронных взаимодействий. Пластичность мозга позволяет ему адаптироваться к новым условиям, формируя новые связи даже во взрослом возрасте. Это объясняет, почему регулярная практика, например слепой печати, улучшает навыки. Тренировки укрепляют нейронные пути, делая движения автоматическими. Мозг также чувствителен к стрессу и усталости, поэтому важно поддерживать баланс между работой и отдыхом. Сон играет ключевую роль в восстановлении мозга, помогая закреплять новую информацию. Изучение работы мозга открывает пути к улучшению памяти, внимания и продуктивности.',
                ],
                [
                    'genre' => 'non-fiction',
                    'text' => 'Технологии развиваются с невероятной скоростью, изменяя нашу жизнь. Ещё сто лет назад люди писали письма от руки, а сегодня мы отправляем сообщения за секунды. История технологий началась с простых орудий труда, созданных тысячи лет назад. Колесо, огонь, металлургия - всё это заложило основу для прогресса. В девятнадцатом веке паровые машины дали толчок промышленной революции. Электричество и телеграф сделали мир ближе. В XX веке компьютеры и интернет радикально изменили общество. Сегодня искусственный интеллект и робототехника открывают новые горизонты. Технологии не только облегчают жизнь, но и создают вызовы. Например, автоматизация заменяет ручной труд, требуя новых навыков. Умение быстро печатать - один из таких навыков, необходимых в цифровую эпоху. Слепая печать экономит время и повышает эффективность работы с компьютером. Важно адаптироваться к изменениям, осваивая новые инструменты. Технологии продолжают эволюционировать, и мы должны учиться вместе с ними, чтобы оставаться конкурентоспособными.',
                ],
                [
                    'genre' => 'non-fiction',
                    'text' => 'Вода - основа жизни на Земле. Без неё невозможны ни биологические процессы, ни существование экосистем. Человеческое тело на 60% состоит из воды, которая участвует во всех функциях организма: от пищеварения до терморегуляции. Вода покрывает около 71% поверхности планеты, но лишь 2,5% из неё - пресная. Это делает доступ к чистой воде глобальной проблемой. Многие регионы страдают от засухи или загрязнения водоёмов. Учёные ищут способы очистки и рационального использования воды. Например, опреснение морской воды становится всё более популярным, хотя требует больших затрат энергии. Каждый человек может внести вклад в сохранение воды, экономя её в быту. Интересно, что вода участвует не только в биологии, но и в культуре. Во многих традициях она символизирует очищение и возрождение. Осознанное отношение к воде помогает сохранить природу и здоровье. Практика слепой печати, как и забота о воде, требует дисциплины и регулярности, чтобы достичь мастерства.',
                ],
                [
                    'genre' => 'non-fiction',
                    'text' => 'Общение - ключ к успешным отношениям, будь то личные или профессиональные. Люди обмениваются информацией через слова, жесты, мимику и даже молчание. Умение слушать так же важно, как умение говорить. Эффективное общение требует ясности, уважения и эмпатии. В современном мире цифровые технологии изменили способы общения. Электронные письма, мессенджеры и видеозвонки стали нормой. Однако это привело к новым вызовам: недопонимание из-за отсутствия невербальных сигналов. Письменное общение, например в рабочих чатах, требует точности и скорости. Здесь пригодится слепая печать, которая позволяет быстро формулировать мысли. Культура общения также включает умение адаптироваться к собеседнику. Например, в разных странах жесты могут иметь противоположные значения. Обучение искусству общения улучшает карьеру и личную жизнь. Регулярная практика, как в печати, так и в разговорах, делает процесс естественным и уверенным.',
                ],
                [
                    'genre' => 'non-fiction',
                    'text' => 'Энергия - движущая сила цивилизации. С древних времён люди использовали огонь, затем воду и ветер для своих нужд. В девятнадцатом веке уголь и нефть стали основой промышленности. Однако их использование привело к экологическим проблемам. Сегодня мир ищет возобновляемые источники энергии: солнечную, ветровую, геотермальную. Солнечные панели и ветряные турбины становятся всё доступнее, но их внедрение требует времени и инвестиций. Ядерная энергия остаётся спорной темой: она эффективна, но связана с рисками. Учёные также исследуют водород как топливо будущего. Переход к чистой энергии - глобальная задача, связанная с изменением климата. Каждый может внести вклад, экономя электроэнергию или выбирая экологичные продукты. Навыки вроде слепой печати помогают работать с информацией об энергетике, анализировать данные и распространять знания. Энергия будущего зависит от осознанных решений и технологических инноваций.',
                ],
                [
                    'genre' => 'non-fiction',
                    'text' => 'Экономика - это система производства, распределения и потребления ресурсов. Она влияет на жизнь каждого человека, от цен на продукты до уровня зарплат. Экономика делится на микро- и макроуровни. Микроэкономика изучает поведение отдельных компаний и потребителей, а макроэкономика - национальные и глобальные процессы, такие как инфляция или безработица. Деньги играют ключевую роль, выступая средством обмена. Центральные банки регулируют денежную массу, влияя на экономическую стабильность. Современная экономика глобальна: товары производятся в одной стране, а продаются в другой. Технологии, такие как блокчейн, меняют финансовые системы, делая транзакции быстрее и прозрачнее. Навыки вроде слепой печати помогают экономистам и аналитикам обрабатывать большие объёмы данных. Понимание экономики позволяет принимать осознанные решения, будь то инвестиции или планирование бюджета.',
                ],
                [
                    'genre' => 'non-fiction',
                    'text' => 'Образование формирует личность и общество. Оно даёт знания, навыки и ценности, необходимые для жизни. Системы образования различаются по странам, но цель у них общая: подготовить людей к вызовам мира. В древности обучение было привилегией элиты, но сегодня оно доступно миллионам. Технологии изменили образование: онлайн-курсы и платформы сделали знания ближе. Однако качество образования остаётся проблемой в некоторых регионах. Учителя играют ключевую роль, вдохновляя учеников и развивая их потенциал. Навыки вроде слепой печати помогают студентам и профессионалам эффективно работать с информацией. Образование не заканчивается в школе - обучение на протяжении всей жизни становится нормой. Постоянное развитие позволяет адаптироваться к изменениям и достигать успеха.',
                ],
                [
                    'genre' => 'non-fiction',
                    'text' => 'Здоровье - основа счастливой жизни. Оно зависит от питания, физической активности, сна и ментального состояния. Сбалансированная диета, богатая овощами, фруктами и белками, поддерживает организм. Регулярные упражнения укрепляют мышцы и сердце, улучшая настроение. Сон восстанавливает тело и мозг, помогая справляться со стрессом. Психическое здоровье не менее важно: медитация и общение с близкими снижают тревожность. Современный ритм жизни часто мешает заботиться о себе, но небольшие привычки, такие как прогулки или отказ от гаджетов перед сном, дают результат. Слепая печать, как и здоровый образ жизни, требует дисциплины и регулярности. Осознанный подход к здоровью увеличивает продолжительность и качество жизни.',
                ],
                [
                    'genre' => 'non-fiction',
                    'text' => 'Изменение климата - одна из главных угроз XXI века. Глобальное потепление, вызванное выбросами парниковых газов, приводит к экстремальным погодным явлениям: ураганам, засухам, наводнениям. Промышленность, транспорт и сельское хозяйство - основные источники выбросов. Учёные призывают сократить использование ископаемого топлива и перейти на возобновляемую энергию. Международные соглашения, такие как Парижское, направлены на снижение углеродного следа. Каждый человек может помочь: сортировка мусора, экономия энергии и отказ от одноразового пластика - простые шаги. Технологии, включая программы для анализа данных, помогают отслеживать изменения климата. Слепая печать полезна для работы с экологическими отчётами и статьями. Защита планеты требует совместных усилий и осознанности.',
                ],
                [
                    'genre' => 'poetry',
                    'text' => <<<EOT
Осень кружит в золотом вальсе,
Листья танцуют на ветре шальном.
Ветви качаются в медленном трансе,
Небо покрыто седым полотном.
Утро встречает холодным дыханьем,
Туман над рекой, словно призрачный дым.
В сердце рождается странное знанье,
Будто мы с осенью вечно одни.
Клены пылают багровым пожаром,
Сосны хранят изумрудную тень.
Время уходит, скрываясь за паром,
Дни улетают, как птицы в даль.
Шаг за шагом по тропам лесным,
Слышу мелодию старых стихов.
Осень зовёт в свои сны золотым,
Где мы танцуем под шорох листов.
Пальцы скользят по клавишам ветра,
Слова рождаются в ритме простом.
Осень - поэзия, вечная метра,
Свет в её строках горит серебром.
Пусть же кружится осенний вальс,
В сердце храня этот миг навсегда.
Время замедлит свой бег хоть на час,
Чтобы запомнить её красота.
EOT,
                ],
                [
                    'genre' => 'poetry',
                    'text' => <<<EOT
Снег опускается мягко на землю,
Ночь укрывает всё белым плащом.
Тишина шепчет: "Забудь про проблемы",
Мир засыпает в холодном сне том.
Звёзды мерцают в морозной короне,
Луна серебрится над спящим селом.
Ветер поёт в одинокой иконе,
Свет отражая в замерзшем стекле.
Скрип под ногами, как старая песня,
След на снегу - это память о дне.
Зима обнимает, и всё так прелестно,
Словно мы в сказке, в волшебной стране.
Дыхание парит, как дым над трубами,
В сердце тепло, несмотря на мороз.
Снежинки танцуют, играя с судьбами,
Каждая падает, будто вопрос.
Пальцы стучат по клавишам ночи,
Стихи оживают в холодной тиши.
Зима - это время, где сердце не хочет
Спешить, а лишь слушать дыханье души.
Пусть же зима сохранит этот свет,
В белом молчанье храня свой ответ.
EOT,
                ],
                [
                    'genre' => 'poetry',
                    'text' => <<<EOT
Весна пробуждает леса и долины,
Ручьи запевают, звеня и журча.
Всё оживает под солнца картины,
Трава зеленеет, как в детстве мечта.
Цветы распускаются в утренней дымке,
Птицы вернулись, их песня слышна.
Весна - это жизнь, это трепет в улыбке,
В ней каждый день - словно новая глава.
Деревья оделись в наряд изумрудный,
Ветер приносит тепло на крылах.
Весна - это время, когда неразумно
Скрывать свои чувства в холодных словах.
Поля оживают под лаской луча,
Земля дышит вольно, как после зимы.
Весна - это песня, что в сердце звучит,
Её мелодия вечно жива.
Пальцы танцуют, как ветви в апреле,
Стихи расцветают, как травы в росе.
Весна - это время, когда мы хотели
Лететь за мечтой в бесконечной красе.
Пусть же весна вдохновляет сердца,
Ведёт нас к началу, где нету конца.
EOT,
                ],
                [
                    'genre' => 'poetry',
                    'text' => <<<EOT
Солнце садится за кромку лесную,
Небо пылает в багровом огне.
Лето ласкает траву расписную,
Тепло сохраняя в души глубине.
Река отражает закатные краски,
Тихо журчит, унося вдаль мечты.
Лето - как сказка в цветочной огласке,
Где каждый миг полон яркой красоты.
Пчёлы гудят в золотистых просторах,
Ветер качает ромашки в полях.
Лето рисует в небесных узорах
Светлые сны, что хранятся в глазах.
Тёплые ночи, усыпаны звёздами,
Млечный Путь манит в бескрайнюю даль.
Лето - как песня, что в сердце созвездием,
Светит и греет, уводя в магистраль.
Пальцы скользят, словно волны в реке,
Стихи оживают в вечерней тиши.
Лето - как память о вечном в строке,
Где мы свободны в объятиях души.
Пусть же закаты пылают всегда,
Лето храня в наших сердцах навсегда.
EOT,
                ],
                [
                    'genre' => 'poetry',
                    'text' => <<<EOT
Море волнуется, плещет у берега,
Пена искрится под солнца лучом.
Волны поют, как старинная элегия,
Манит простор за далёким бортом.
Чайки кружатся над синим раздольем,
Ветер приносит солёный привет.
Море - как вечность, что дышит привольем,
В нём утопает закатный багрянец.
Горизонт тает в туманной дымке,
Свет отражён в миллионах зеркал.
Море - как песня, что в сердце возникла,
Голос его - это древний хорал.
Каждая волна - как строка на странице,
Каждый прибой - это ритм бытия.
Море зовёт, чтобы в нём раствориться,
Слиться с его бесконечной мечтой.
Пальцы стучат, словно капли дождя,
Стихи оживают, как пена морская.
Море в душе - это жизнь и огня,
Свет, что горит, никогда не сгорая.
Пусть же море поёт в нас всегда,
В сердце храня свою синюю звезду.
EOT,
                ],
                [
                    'genre' => 'poetry',
                    'text' => <<<EOT
Город сияет в огнях разноцветных,
Улицы дышат в ночной суете.
Фонари светят в глазах запоздалых,
Сны растворяются в дымке мечты.
Шум машин, шаги, голоса,
Небо укрыто мерцающим флёром.
Город живёт, как большая пьеса,
Каждый в ней - актёр с личным сюжетом.
Окна домов, как глаза в полумраке,
Светят теплом в бесконечной ночи.
Город - как книга, где в каждой строке
Скрыты надежды, сомненья, лучи.
Мосты над рекой, как старинные арки,
Время хранят в своих каменных снах.
Город - как песня, что в сердце не гаснет,
Свет её вечно живёт в голосах.
Пальцы стучат, как шаги по асфальту,
Стихи оживают в ночной тишине.
Город - как память, что в сердце осталась,
Светом своим согревая во мне.
Пусть же город сияет в ночи,
В сердце храня свои звёзды лучи.
EOT,
                ],
                [
                    'genre' => 'poetry',
                    'text' => <<<EOT
Дождь барабанит по крышам и стёклам,
Капли танцуют в серебряной мгле.
Небо укрыто свинцовым потоком,
Мир утопает в прохладной волне.
Лужи мерцают, как зеркала ночи,
Ветер приносит дыханье дождя.
Каждая капля - как строчка в блокноте,
Песня природы, что вечно жива.
Деревья клонятся, шепчут о чём-то,
Листья блестят под потоками вод.
Дождь - это танец, где всё так знакомо,
В нём оживает души хоровод.
Тишина тонет в мелодии ливня,
Сердце стучит в унисон с небесами.
Дождь - это песня, что вечно красива,
Свет её льётся в открытых глазах.
Пальцы скользят, словно капли по стеклу,
Стихи оживают в ритме дождя.
Пусть же танцует он в сердце и веку,
Светом своим наполняя меня.
Дождь не смолкает, поёт в тишине,
Вечно живёт в моей светлой душе.
EOT,
                ],
                [
                    'genre' => 'poetry',
                    'text' => <<<EOT
Горы встают в предрассветной дымке,
Солнце касается их снежных вершин.
Тишина шепчет в холодной улыбке,
Мир оживает в дыханье равнин.
Скалы хранят миллионы историй,
Ветер поёт о былых временах.
Горы - как вечность, что в сердце осталась,
Свет их живёт в молчаливых словах.
Тропы вьются меж каменных стен,
Каждый шаг - ближе к небесной черте.
Рассвет разгорается, словно сирень,
Краски рождая в утренней мечте.
Облака плывут, как лёгкие сны,
Свет отражается в звонких ручьях.
Горы зовут, их голос слышны,
В сердце рождая огонь в зеркалах.
Пальцы стучат, как шаги по тропе,
Стихи оживают в горной тиши.
Рассвет над горами - свет в моей душе,
В нём оживает дыханье души.
Пусть же горы хранят этот свет,
В сердце моём оставляя ответ.
EOT,
                ],
                [
                    'genre' => 'poetry',
                    'text' => <<<EOT
Ветер поёт над просторами мира,
Вольный, как птица, летит в облака.
В нём оживает мелодия лиры,
Свет его вечно свободен, легка.
Листья танцуют в его объятьях,
Травы качаются в ритме простом.
Ветер приносит далёкие вести,
Светом своим согревая наш дом.
Он пролетает над синим раздольем,
Море волнует, ласкает поля.
Ветер - как память о вечном приволье,
Голос его - это песня моя.
В каждом порыве - дыханье свободы,
В каждом движенье - надежда жива.
Ветер уносит тревоги, невзгоды,
Светом своим наполняя слова.
Пальцы скользят, как потоки ветров,
Стихи оживают в их лёгкой игре.
Ветер - как песня, что в сердце готов,
Свет её вечно горит в январе.
Пусть же ветер поёт в небесах,
Светом своим согревая в сердцах.
EOT,
                ],
                [
                    'genre' => 'poetry',
                    'text' => <<<EOT
Звёзды мерцают в бескрайней ночи,
Млечный Путь манит в далёкую высь.
Тишина шепчет: "Забудь о тоске",
Свет её вечно хранится в душе.
Каждая звезда - как чья-то надежда,
Свет её в сердце рождает мечту.
Ночь раскрывает свои тайны нежно,
В них оживает небес красота.
Галактики кружат в космическом танце,
Время застыло в их вечном пути.
Звёзды зовут, и в их ярком убранстве
Светом своим помогают идти.
Мир бесконечен, как сны в тишине,
В нём растворяюсь, как в море огней.
Звёзды - как строки в небесной строке,
Свет их живёт в каждом сердце людей.
Пальцы стучат, словно звёзды горят,
Стихи оживают в их вечном огне.
Путь звёздный манит, и в сердце звучат
Песни о вечности в светлой волне.
Пусть же звёзды горят в небесах,
Светом своим согревая в сердцах.
EOT,
                ],
            ],
        ];

        foreach ($texts as $language => $languageTexts) {
            foreach ($languageTexts as $textData) {
                TestText::create([
                    'language' => $language,
                    'genre' => $textData['genre'],
                    'text' => $textData['text'],
                ]);
            }
        }
    }
}
