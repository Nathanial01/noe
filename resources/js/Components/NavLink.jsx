

import { useEffect, useRef } from 'react';
import { Link } from '@inertiajs/react';

export default function NavLink({
  active = false,
  className = '',
  children,
  ...props
}) {
  const linkRef = useRef(null); // Reference to the Link element

  return (
    <Link
      {...props}
      ref={linkRef}
      className={
        'inline-flex items-center   font-semibold leading-6 transition-all duration-300 ease-in-out transform relative overflow-hidden rounded-md ' +
        (active
          ? 'bg-dodgerblue text-white dark:text-gray-100'
          : 'bg-transparent   text-gray-50  dark:text-gray-50   dark:hover:text-indigo-400  hover:text-indigo-200 ') +
        ' ' +
        className
      }
    >
      {children}
    </Link>
  );
}



