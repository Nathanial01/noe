import React from "react";
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import DarkModeToggle from "@/Components/DarkModeToggle";

export default function Register() {
    const { data, setData, post, processing, errors, reset } = useForm({
        // Personal Information
        first_name: '',
        last_name: '',
        date_of_birth: '',
        nationality: '',
        country_of_residence: '',
        gender: '',
        marital_status: '',
        // Contact Details
        email: '',
        phone: '',
        residential_address: '',
        // Authentication
        password: '',
        password_confirmation: '',
    });

    const submit = (e) => {
        e.preventDefault();

        post(route('register'), {
            onFinish: () => reset('password', 'password_confirmation'),
        });
    };

    return (
        <GuestLayout>
            <Head title="Register" />
            {/* Dark Mode Toggle */}
            <div className="block px-2 py-2">
                <DarkModeToggle />
            </div>
            <form onSubmit={submit}>
                {/* Personal Information */}
                <fieldset className="mb-6">
                    <legend className="text-xl font-bold mb-4">Personal Information</legend>
                    <div>
                        <InputLabel htmlFor="first_name" value="First Name" />
                        <TextInput
                            id="first_name"
                            name="first_name"
                            value={data.first_name}
                            className="w-full h-14 px-4 rounded-lg bg-gray-300 text-gray-900 border border-gray-700 focus:outline-none dark:bg-gray-900 dark:text-gray-100 dark:border-gray-600"
                            autoComplete="given-name"
                            isFocused={true}
                            onChange={(e) => setData('first_name', e.target.value)}
                            required
                        />
                        <InputError message={errors.first_name} className="mt-2" />
                    </div>
                    <div className="mt-4">
                        <InputLabel htmlFor="last_name" value="Last Name" />
                        <TextInput
                            id="last_name"
                            name="last_name"
                            value={data.last_name}
                            className="w-full h-14 px-4 rounded-lg bg-gray-300 text-gray-900 border border-gray-700 focus:outline-none dark:bg-gray-900 dark:text-gray-100 dark:border-gray-600"
                            autoComplete="family-name"
                            onChange={(e) => setData('last_name', e.target.value)}
                            required
                        />
                        <InputError message={errors.last_name} className="mt-2" />
                    </div>
                    <div className="mt-4">
                        <InputLabel htmlFor="date_of_birth" value="Date of Birth" />
                        <TextInput
                            id="date_of_birth"
                            type="date"
                            name="date_of_birth"
                            value={data.date_of_birth}
                            className="w-full h-14 px-4 rounded-lg bg-gray-300 text-gray-900 border border-gray-700 focus:outline-none dark:bg-gray-900 dark:text-gray-100 dark:border-gray-600"
                            onChange={(e) => setData('date_of_birth', e.target.value)}
                            required
                        />
                        <InputError message={errors.date_of_birth} className="mt-2" />
                    </div>
                    <div className="mt-4">
                        <InputLabel htmlFor="nationality" value="Nationality" />
                        <TextInput
                            id="nationality"
                            name="nationality"
                            value={data.nationality}
                            className="w-full h-14 px-4 rounded-lg bg-gray-300 text-gray-900 border border-gray-700 focus:outline-none dark:bg-gray-900 dark:text-gray-100 dark:border-gray-600"
                            onChange={(e) => setData('nationality', e.target.value)}
                            required
                        />
                        <InputError message={errors.nationality} className="mt-2" />
                    </div>
                    <div className="mt-4">
                        <InputLabel htmlFor="country_of_residence" value="Country of Residence" />
                        <TextInput
                            id="country_of_residence"
                            name="country_of_residence"
                            value={data.country_of_residence}
                            className="w-full h-14 px-4 rounded-lg bg-gray-300 text-gray-900 border border-gray-700 focus:outline-none dark:bg-gray-900 dark:text-gray-100 dark:border-gray-600"
                            onChange={(e) => setData('country_of_residence', e.target.value)}
                            required
                        />
                        <InputError message={errors.country_of_residence} className="mt-2" />
                    </div>
                    <div className="mt-4">
                        <InputLabel htmlFor="gender" value="Gender" />
                        <select
                            id="gender"
                            name="gender"
                            value={data.gender}
                            className="w-full h-14 px-4 rounded-lg bg-gray-300 text-gray-900 border focus:outline-none dark:text-gray-900 dark:border-gray-600"
                            onChange={(e) => setData('gender', e.target.value)}
                            required
                        >
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                        <InputError message={errors.gender} className="mt-2" />
                    </div>
                    <div className="mt-4">
                        <InputLabel htmlFor="marital_status" value="Marital Status" />
                        <select
                            id="marital_status"
                            name="marital_status"
                            value={data.marital_status}
                            className="w-full h-14 px-4 rounded-lg bg-gray-300 text-gray-900 border focus:outline-none dark:text-gray-900 dark:border-gray-600"
                            onChange={(e) => setData('marital_status', e.target.value)}
                        >
                            <option value="">Select Status</option>
                            <option value="single">Single</option>
                            <option value="married">Married</option>
                            <option value="divorced">Divorced</option>
                            <option value="widowed">Widowed</option>
                        </select>
                        <InputError message={errors.marital_status} className="mt-2" />
                    </div>
                </fieldset>

                {/* Contact Details */}
                <fieldset className="mb-6">
                    <legend className="text-xl font-bold mb-4">Contact Details</legend>
                    <div>
                        <InputLabel htmlFor="email" value="Email" />
                        <TextInput
                            id="email"
                            type="email"
                            name="email"
                            value={data.email}
                            className="w-full h-14 px-4 rounded-lg bg-gray-300 text-gray-900 border border-gray-700 focus:outline-none dark:bg-gray-900 dark:text-gray-100 dark:border-gray-600"
                            autoComplete="email"
                            onChange={(e) => setData('email', e.target.value)}
                            required
                        />
                        <InputError message={errors.email} className="mt-2" />
                    </div>
                    <div className="mt-4">
                        <InputLabel htmlFor="phone" value="Phone" />
                        <TextInput
                            id="phone"
                            type="tel"
                            name="phone"
                            value={data.phone}
                            className="w-full h-14 px-4 rounded-lg bg-gray-300 text-gray-900 border border-gray-700 focus:outline-none dark:bg-gray-900 dark:text-gray-100 dark:border-gray-600"
                            autoComplete="tel"
                            onChange={(e) => setData('phone', e.target.value)}
                        />
                        <InputError message={errors.phone} className="mt-2" />
                    </div>
                    <div className="mt-4">
                        <InputLabel htmlFor="residential_address" value="Residential Address" />
                        <TextInput
                            id="residential_address"
                            name="residential_address"
                            value={data.residential_address}
                            className="w-full h-14 px-4 rounded-lg bg-gray-300 text-gray-900 border border-gray-700 focus:outline-none dark:bg-gray-900 dark:text-gray-100 dark:border-gray-600"
                            onChange={(e) => setData('residential_address', e.target.value)}
                        />
                        <InputError message={errors.residential_address} className="mt-2" />
                    </div>
                </fieldset>

                {/* Authentication */}
                <fieldset className="mb-6">
                    <legend className="text-xl font-bold mb-4">Authentication</legend>
                    <div>
                        <InputLabel htmlFor="password" value="Password" />
                        <TextInput
                            id="password"
                            type="password"
                            name="password"
                            value={data.password}
                            className="w-full h-14 px-4 rounded-lg bg-gray-300 text-gray-900 border border-gray-700 focus:outline-none dark:bg-gray-900 dark:text-gray-100 dark:border-gray-600"
                            autoComplete="new-password"
                            onChange={(e) => setData('password', e.target.value)}
                            required
                        />
                        <InputError message={errors.password} className="mt-2" />
                    </div>
                    <div className="mt-4">
                        <InputLabel htmlFor="password_confirmation" value="Confirm Password" />
                        <TextInput
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            value={data.password_confirmation}
                            className="w-full h-14 px-4 rounded-lg bg-gray-300 border border-gray-700 focus:outline-none dark:bg-gray-900 dark:text-gray-100 dark:border-gray-600"
                            autoComplete="new-password"
                            onChange={(e) => setData('password_confirmation', e.target.value)}
                            required
                        />
                        <InputError message={errors.password_confirmation} className="mt-2" />
                    </div>
                </fieldset>

                {/* Submit Button */}
                <div className="mt-6 flex items-center justify-end">
                    <Link
                        href={route('login')}
                        className="rounded-md text-sm text-gray-900 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
                    >
                        Already registered?
                    </Link>
                    <PrimaryButton className="ml-4" disabled={processing}>
                        Register
                    </PrimaryButton>
                </div>
            </form>
        </GuestLayout>
    );
}
