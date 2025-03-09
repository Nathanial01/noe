import React, { useEffect, useRef, useState } from "react";
import { Helmet } from "react-helmet";
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";


gsap.registerPlugin(ScrollTrigger);

// CountUp component: animates a number from 0 to the target when scrolled into view.
const CountUp = ({ target, prefix = "", suffix = "", duration = 2, decimals = 0 }) => {
    const [count, setCount] = useState(0);
    const elementRef = useRef(null);

    useEffect(() => {
        let obj = { val: 0 };

        ScrollTrigger.create({
            trigger: elementRef.current,
            start: "top 80%",
            once: true,
            onEnter: () => {
                gsap.to(obj, {
                    val: target,
                    duration: duration,
                    ease: "power1.out",
                    onUpdate: () => setCount(obj.val.toFixed(decimals)),
                });
            },
        });
    }, [target, duration, decimals]);

    return <span ref={elementRef}>{prefix}{count}{suffix}</span>;
};

export default function FeatureAboutUs() {
    const stats = [
        { id: 1, name: 'Transactions every 24 hours', target: 44, suffix: " million", prefix: "" },
        { id: 2, name: 'Assets under holding', target: 119, suffix: " trillion", prefix: "$" },
        { id: 3, name: 'New users annually', target: 46000, suffix: "", prefix: "" },
    ];

    return (

            <div className="overflow-hidden bg-none dark:bg-none py-24 sm:py-32">
                <div className="mx-auto max-w-2xl px-6 lg:max-w-7xl lg:px-8">
                    <div className="max-w-4xl">
                        <p className="text-base/7 font-semibold text-indigo-400 ">About us</p>
                        <h1 className="mt-2 text-pretty text-4xl font-semibold tracking-tight text-gray-50 dark:text-gray-100 sm:text-5xl">
                            On a mission to empower remote teams
                        </h1>
                        <p className="mt-6 text-balance text-xl/8 text-gray-100">
                            Aliquet nec orci mattis amet quisque ullamcorper neque, nibh sem. At arcu, sit dui mi, nibh dui, diam eget
                            aliquam. Quisque id at vitae feugiat egestas.
                        </p>
                    </div>
                    <section className="mt-20 grid grid-cols-1 lg:grid-cols-2 lg:gap-x-8 lg:gap-y-16">
                        <div className="lg:pr-8">
                            <h2 className="text-pretty text-2xl font-semibold tracking-tight text-indigo-400">
                                Our mission
                            </h2>
                            <p className="mt-6 text-base/7 text-gray-50 dark:text-gray-300">
                                Faucibus commodo massa rhoncus, volutpat. Dignissim sed eget risus enim. Mattis mauris semper sed amet
                                vitae sed turpis id. Id dolor praesent donec est. Odio penatibus risus viverra tellus varius sit neque
                                erat velit. Faucibus commodo massa rhoncus, volutpat. Dignissim sed eget risus enim. Mattis mauris semper
                                sed amet vitae sed turpis id.
                            </p>
                            <p className="mt-8 text-base/7 text-gray-50 dark:text-gray-300">
                                Et vitae blandit facilisi magna lacus commodo. Vitae sapien duis odio id et. Id blandit molestie auctor
                                fermentum dignissim. Lacus diam tincidunt ac cursus in vel. Mauris varius vulputate et ultrices hac
                                adipiscing egestas. Iaculis convallis ac tempor et ut. Ac lorem vel integer orci.
                            </p>
                        </div>
                        <div className="pt-16 lg:row-span-2 lg:-mr-16 xl:mr-auto">
                            <div className="-mx-8 grid grid-cols-2 gap-4 sm:-mx-16 sm:grid-cols-4 lg:mx-0 lg:grid-cols-2 lg:gap-4 xl:gap-8">
                                <div className="aspect-square overflow-hidden rounded-xl shadow-xl outline outline-1 -outline-offset-1 outline-black/10">
                                    <img
                                        alt=""
                                        src="https://images.unsplash.com/photo-1590650516494-0c8e4a4dd67e?&auto=format&fit=crop&crop=center&w=560&h=560&q=90"
                                        className="block w-full object-cover"
                                    />
                                </div>
                                <div className="-mt-8 aspect-square overflow-hidden rounded-xl shadow-xl outline outline-1 -outline-offset-1 outline-black/10 lg:-mt-40">
                                    <img
                                        alt=""
                                        src="https://images.unsplash.com/photo-1557804506-669a67965ba0?&auto=format&fit=crop&crop=left&w=560&h=560&q=90"
                                        className="block w-full object-cover"
                                    />
                                </div>
                                <div className="aspect-square overflow-hidden rounded-xl shadow-xl outline outline-1 -outline-offset-1 outline-black/10">
                                    <img
                                        alt=""
                                        src="https://images.unsplash.com/photo-1559136555-9303baea8ebd?&auto=format&fit=crop&crop=left&w=560&h=560&q=90"
                                        className="block w-full object-cover"
                                    />
                                </div>
                                <div className="-mt-8 aspect-square overflow-hidden rounded-xl shadow-xl outline outline-1 -outline-offset-1 outline-black/10 lg:-mt-40">
                                    <img
                                        alt=""
                                        src="https://images.unsplash.com/photo-1598257006458-087169a1f08d?&auto=format&fit=crop&crop=center&w=560&h=560&q=90"
                                        className="block w-full object-cover"
                                    />
                                </div>
                            </div>
                        </div>
                        <div className="max-lg:mt-16 lg:col-span-1">
                            <p className="text-base/7 font-semibold text-indigo-400">The numbers</p>
                            <hr className="mt-6 border-t border-gray-200" />
                            <dl className="mt-6 grid grid-cols-1 gap-x-8 gap-y-4 sm:grid-cols-2">
                                <div className="flex flex-col gap-y-2 border-b border-dotted border-gray-200 pb-4">
                                    <dt className="text-sm/6 text-gray-50 dark:text-gray-300">Raised</dt>
                                    <dd className="order-first text-6xl text-gray-50 dark:text-gray-300 font-semibold tracking-tight">
                                        $<CountUp target={150} />M
                                    </dd>
                                </div>
                                <div className="flex flex-col gap-y-2 border-b border-dotted border-gray-200 pb-4">
                                    <dt className="text-sm/6 text-gray-50 dark:text-gray-300">Companies</dt>
                                    <dd className="order-first text-6xl font-semibold tracking-tight text-gray-50 dark:text-gray-300">
                                        <CountUp target={30} />K
                                    </dd>
                                </div>
                                <div className="flex flex-col gap-y-2 max-sm:border-b max-sm:border-dotted max-sm:border-gray-200 max-sm:pb-4">
                                    <dt className="text-sm/6 text-gray-50 dark:text-gray-300">Deals Closed</dt>
                                    <dd className="order-first text-6xl font-semibold tracking-tight text-gray-50 dark:text-gray-300">
                                        <CountUp target={1.5} duration={3} />M
                                    </dd>
                                </div>
                                <div className="flex flex-col gap-y-2">
                                    <dt className="text-sm/6 text-gray-50">Leads Generated</dt>
                                    <dd className="order-first text-6xl font-semibold tracking-tight text-gray-50 dark:text-gray-300">
                                        <CountUp target={200} />M
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </section>
                    <div className="nav py-24 sm:py-32">
                        <div className="mx-auto max-w-7xl px-6 lg:px-8">
                            <dl className="grid grid-cols-1 gap-x-8 gap-y-16 text-center lg:grid-cols-3">
                                {stats.map((stat) => (
                                    <div key={stat.id} className="mx-auto flex max-w-xs flex-col gap-y-4">
                                        <dt className="text-base/7 text-gray-400">{stat.name}</dt>
                                        <dd className="order-first text-3xl font-semibold tracking-tight text-gray-50 sm:text-5xl">
                                            <CountUp target={stat.target} prefix={stat.prefix} suffix={stat.suffix} />
                                        </dd>
                                    </div>
                                ))}
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

    );
}
