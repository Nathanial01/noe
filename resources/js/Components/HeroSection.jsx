import React from "react";

export default function HeroSection() {
    return (
        <section className="relative  h-[652px] mx-auto -mt-40">

            <div className="absolute -left-20 -top-20 z-10">
                <h1
                    className="
            absolute left-0 top-0 w-[357px] h-[129px]
            font-semibold text-[64px] leading-normal font-[Poppins]
            bg-clip-text text-transparent
            bg-[linear-gradient(90deg,#FFF_58%,#7344B8_100%)]
            text-shadow-[0px_4px_4px_rgba(0,0,0,0.38)]
          "
                >
                    Make<span>&nbsp;</span>your
                </h1>
            </div>

                {/* "Make your" + "Dre" Text */}

                <div className="absolute -left-96 top-0 z-10">
                    {/* "Make your" Text */}


                    <h1
                        className="
            absolute left-[357px] top-0 w-[463px] h-[332px]
            font-black text-[200px] leading-[109%] font-[Poppins]
            bg-clip-text text-transparent
            bg-[linear-gradient(287deg,#581CAF_22.12%,#BEB0D1_44.63%,#FFF_66.82%)]
          "
                    >
                        Dre
                    </h1>
                </div>

                {/* Avatar (Women Image) */}
                <div className="absolute left-20 top-24 z-20">
                    <div
                        className="
            w-[434px] h-[543px] bg-cover bg-no-repeat bg-center
            bg-[url('/img/landing/women-2.png')]
          "
                    />
                </div>

                {/* "am" Text */}
                <div className="absolute left-80 top-40 z-30">
                    <h1
                        className="
            w-[486px] h-[327px]
            font-black text-[200px] leading-[109%] font-[Poppins]
            bg-clip-text text-transparent
            bg-[linear-gradient(282deg,#F1AB4F_-0.07%,#581CAF_85.35%)]
          "
                    >
                        am
                    </h1>
                </div>

                {/* "Come true!" Text */}
                <div className="absolute left-40 top-[497px] z-40">
                    <h2
                        className="
            w-[573px] h-[114px] text-right
            font-semibold text-[56px] font-[Poppins]
            bg-clip-text text-transparent
            bg-[linear-gradient(90deg,#5B1FAD_0%,#FC0_100%)]
          "
                    >
                        Come<span>&nbsp;</span>true!
                    </h2>
                </div>
        </section>
);
}
