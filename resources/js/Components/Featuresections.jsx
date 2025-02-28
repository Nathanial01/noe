import {
    ArrowPathIcon,
    CloudArrowUpIcon,
    Cog6ToothIcon,
    FingerPrintIcon,
    LockClosedIcon,
    ServerIcon,
} from '@heroicons/react/20/solid';
import LottieBackground from "./LottieBackground";

const features = [
    {
        name: 'Push to deploy.',
        description: 'Lorem ipsum, dolor sit amet consectetur adipisicing elit aute id magna.',
        icon: CloudArrowUpIcon,
    },
    {
        name: 'SSL certificates.',
        description: 'Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo.',
        icon: LockClosedIcon,
    },
    {
        name: 'Simple queues.',
        description: 'Ac tincidunt sapien vehicula erat auctor pellentesque rhoncus.',
        icon: ArrowPathIcon,
    },
    {
        name: 'Advanced security.',
        description: 'Lorem ipsum, dolor sit amet consectetur adipisicing elit aute id magna.',
        icon: FingerPrintIcon,
    },
    {
        name: 'Powerful API.',
        description: 'Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo.',
        icon: Cog6ToothIcon,
    },
    {
        name: 'Database backups.',
        description: 'Ac tincidunt sapien vehicula erat auctor pellentesque rhoncus.',
        icon: ServerIcon,
    },
];

export default function Featuresections() {
    return (
        <div className="bg-none py-24 sm:py-32 mt-2 w-full">
            <div className="flex flex-col sm:flex-row items-center w-full px-6 gap-8 sm:gap-24 justify-evenly">
                {/* Text Section */}
                <div
                    className="w-full sm:w-1/2 text-center sm:text-left text-white font-poppins font-semibold leading-normal"
                    style={{
                        textShadow: "0px 4px 4px rgba(0, 0, 0, 0.25)",
                        WebkitTextStrokeWidth: "4px",
                        WebkitTextStrokeColor: "#FFF",
                    }}
                >
                    <p className="text-4xl sm:text-5xl md:text-6xl lg:text-[96px]">
                        From Vision to Value— We Scale, We Succeed.
                    </p>
                </div>

                {/* Lottie Background Section */}
                <div className="w-full sm:w-1/2 ml-auto transform translate-x-0 sm:translate-x-40 mt-16">
                    <LottieBackground />
                </div>
            </div>

            <div className="w-full mt-16 px-6">
                <dl className="grid grid-cols-1 gap-x-6 gap-y-10 text-base text-gray-900 dark:text-gray-100 sm:grid-cols-2 lg:grid-cols-3 lg:gap-x-8 lg:gap-y-16">
                    {features.map((feature) => (
                        <div key={feature.name} className="relative pl-9">
                            <dt className="inline font-semibold text-gray-900 dark:text-gray-100">
                                <feature.icon
                                    aria-hidden="true"
                                    className="absolute left-1 top-1 h-5 w-5 text-indigo-500"
                                />
                                {feature.name}
                            </dt>
                            <dd className="inline">{feature.description}</dd>
                        </div>
                    ))}
                </dl>
            </div>
        </div>
    );
}
