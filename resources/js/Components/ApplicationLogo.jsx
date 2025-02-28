import React, { useEffect, useState } from "react";
import Lottie from "lottie-react";

const LottieBackground = () => {
    const [animationData, setAnimationData] = useState(null);

    useEffect(() => {
        fetch("/GIF/noe.json")
            .then((res) => res.json())
            .then((data) => setAnimationData(data))
            .catch((err) => console.error("Error loading Lottie JSON:", err));
    }, []);

    if (!animationData) {
        return (
            <div className="">
                Loading GIF...
            </div>
        );
    }

    return (
        <div className="h-12 w-12 sm:h-16 sm:w-16">
            <Lottie animationData={animationData} loop={true} />
        </div>
    );
};

export default LottieBackground;
