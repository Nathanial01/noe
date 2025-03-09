import React from "react";

const NotificationBar = () => {
    const items = [
        {
            text: "Noe Captal.app",
            subtext:
                "Met Noe Captal kunt u eenvoudig een volledig huis, gebouw of gebied scannen met geavanceerde software. Ontvang een nauwkeurige plattegrond en gedetailleerde lay-out voor woningen en gebouwen.",
            link: "https://www.noecaptalinvestment.com",
            client: "Untitled.svg",
        },
        {
            text: "Noe Captal Technologie",
            subtext:
                "Noe Captal maakt gebruik van cutting-edge technologie om professionals en particulieren te helpen bij het in kaart brengen en plannen van vastgoedprojecten. Voor vragen: support@noecaptalinvestment.com",
            link: "mailto:support@noecaptalinvestment.com",
            client: "Untitled.svg",
        },
        {
            text: "Innovatieve Vastgoedoplossingen",
            subtext:
                "Ontdek de kracht van Noe Captal. Bespaar tijd en kosten bij het ontwerpen, renoveren of verkopen van uw vastgoed door nauwkeurige en snelle digitale indelingen.",
            link: "https://www.noecaptalinvestment.com",
            client: "Untitled.svg",
        },
    ];

    return (
        <div className=" z-50 bg-none backdrop-blur-3xl">
            <div className="flex animate-marquee space-x-8 text-gray-300 dark:text-gray-50">
                {items.map((item, index) => (
                    <a
                        key={index}
                        href={item.link}
                        target="_blank"
                        rel="noopener noreferrer"
                        className="flex-shrink-0 px-4 py-2 whitespace-nowrap"
                    >
                        <div className="flex items-center space-x-2">
                            <img
                                src="/img/logo.png"
                                alt="logo"
                                className="w-100 h-6"
                            />
                            <span className="text-sm">{item.subtext}</span>
                        </div>
                    </a>
                ))}
                {/* Duplicate items for seamless scrolling */}
                {items.map((item, index) => (
                    <a
                        key={`duplicate-${index}`}
                        href={item.link}
                        target="_blank"
                        rel="noopener noreferrer"
                        className="flex-shrink-0 px-4 py-2 whitespace-nowrap"
                    >
                        <div className="flex items-center space-x-2">
                            <img
                                src="/img/landing/logo.svg"
                                alt="logo"
                                className="w-100 h-6"
                            />
                            <span className="text-sm">{item.subtext}</span>
                        </div>
                    </a>
                ))}
            </div>
        </div>
    );
};

export default NotificationBar;
